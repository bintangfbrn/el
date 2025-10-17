<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceHighlight;
use App\Models\ServiceHighlightFeature;
use App\Models\ServiceHighlightImage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Traits\GeneralFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ServiceController extends Controller
{
    public function index()
    {
        PermissionChecking(['view_service', 'create_service', 'edit_service', 'delete_service']);
        $highlight = ServiceHighlight::with(['features', 'images'])->first();
        $images = $highlight ? ServiceHighlightImage::where('highlight_id', $highlight->id)->get() : collect();
        return view('LandingPage.admin.services.index', compact('highlight', 'images'));
    }

    public function store(Request $request)
    {
        PermissionChecking(['create_service', 'edit_service']);
        DB::beginTransaction();

        try {
            $highlight = ServiceHighlight::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'title' => $request->title,
                    'subtitle' => $request->sub_title,
                    'description' => $request->description,
                ]
            );

            for ($i = 1; $i <= 4; $i++) {
                $field = 'image_' . $i;
                if ($request->hasFile($field)) {
                    if ($highlight->$field && Storage::disk('public')->exists($highlight->$field)) {
                        Storage::disk('public')->delete($highlight->$field);
                    }

                    $path = $request->file($field)->store('services', 'public');
                    $highlight->$field = $path;
                }
            }

            $highlight->save();

            if ($request->has('features')) {
                $submittedIds = collect($request->features)->pluck('id')->filter()->toArray();
                ServiceHighlightFeature::where('highlight_id', $highlight->id)
                    ->whereNotIn('id', $submittedIds)
                    ->delete();

                foreach ($request->features as $index => $feature) {
                    if (empty($feature['title'])) continue;

                    $iconPath = $feature['icon'] ?? null;
                    if ($request->hasFile("features.$index.icon")) {
                        $file = $request->file("features.$index.icon");

                        if ($file && $file->isValid()) {
                            $destination = public_path('storage/services/icons');
                            if (!file_exists($destination)) mkdir($destination, 0775, true);

                            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $file->move($destination, $fileName);
                            $iconPath = 'services/icons/' . $fileName;
                        }
                    }

                    if (!empty($feature['id'])) {
                        $existing = ServiceHighlightFeature::find($feature['id']);
                        if ($existing) {
                            $existing->update([
                                'icon' => $iconPath ?? $existing->icon,
                                'title' => $feature['title'],
                                'description' => $feature['description'] ?? null,
                            ]);
                        }
                    } else {
                        ServiceHighlightFeature::create([
                            'highlight_id' => $highlight->id,
                            'icon' => $iconPath,
                            'title' => $feature['title'],
                            'description' => $feature['description'] ?? null,
                        ]);
                    }
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    if (!$file || !$file->isValid()) continue;

                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $destination = public_path('storage/services');
                    if (!file_exists($destination)) {
                        mkdir($destination, 0755, true);
                    }

                    $file->move($destination, $fileName);
                    $path = 'services/' . $fileName;
                    $existingImage = $highlight->images->get($index);

                    if ($existingImage) {
                        $existingImage->update([
                            'image_path' => $path
                        ]);
                    } else {
                        ServiceHighlightImage::create([
                            'highlight_id' => $highlight->id,
                            'image_path' => $path,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()
                ->back()
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Success!',
                    'text' => 'Data Service Highlight berhasil disimpan.',
                    'confirmButtonText' => 'OK'
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error!',
                    'text' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'confirmButtonText' => 'OK, I Understand'
                ])
                ->withInput();
        }
    }

    public function index_services_items(Request $request)
    {
        PermissionChecking(['view_service', 'create_service', 'edit_service', 'delete_service']);

        if ($request->ajax()) {
            $services = Service::orderBy('created_at', 'desc')->get();

            return DataTables::of($services)
                ->addIndexColumn()
                ->editColumn('status', function ($services) {
                    if ($services->status == 0) {
                        $status = '<span class="badge bg-label-warning">Tidak Aktif</span>';
                    } else if ($services->status == 1) {
                        $status = '<span class="badge bg-label-success">Aktif</span>';
                    } else {
                        $status = '-';
                    }
                    return $status;
                })
                ->editColumn('pin', function ($services) {
                    if ($services->pin == 0) {
                        $status = '<span class="badge bg-label-warning">Reguler</span>';
                    } else if ($services->pin == 1) {
                        $status = '<span class="badge bg-label-success">Pinned</span>';
                    } else {
                        $status = '-';
                    }
                    return $status;
                })
                ->addColumn('aksi', function ($services) {
                    $id = encrypt($services->id);
                    $btn = '<div class="btn-group" role="group" aria-label="Action">';

                    // 🔍 Tombol Detail (modal)
                    $btn .= '<button type="button" class="btn btn-icon btn-info detail"
                        data-id="' . $id . '"
                        title="Lihat Detail">
                        <i class="fa-solid fa-eye"></i>
                    </button>';

                    // ✏️ Tombol Edit (redirect page)
                    $btn .= '<a href="' . route('edit-services-items', $id) . '"
                        class="btn btn-icon btn-warning ms-1"
                        title="Edit Data">
                        <i class="fa-solid fa-edit"></i>
                    </a>';

                    // 🗑️ Tombol Delete (ajax + swal)
                    $btn .= '<button type="button" class="btn btn-icon btn-danger delete ms-1"
                        data-id="' . $id . '"
                        title="Hapus Data">
                        <i class="fa-solid fa-trash"></i>
                    </button>';

                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['aksi', 'status', 'pin'])
                ->make(true);
        } else {
            $title = 'Services Items';
            $serviceItems = Service::orderBy('created_at', 'desc')->get();

            return view('LandingPage.admin.services-items.index', compact('title', 'serviceItems'));
        }
    }

    public function create_services_items()
    {
        PermissionChecking(['create_service', 'edit_service']);
        $title = 'Tambah Services';

        return view('LandingPage.admin.services-items.create', compact('title'));
    }

    public function store_services_items(Request $request)
    {
        PermissionChecking(['create_service', 'edit_service']);

        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // max 5MB
            'image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'required|in:0,1',
            'pin' => 'required|in:0,1',
        ]);

        try {

            $destination = public_path('storage/services');

            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $imagePath = null;
            $imagePath2 = null;


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_1_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $fileName);
                $imagePath = 'services/' . $fileName;
            }


            if ($request->hasFile('image_2')) {
                $file2 = $request->file('image_2');
                $fileName2 = time() . '_2_' . Str::slug(pathinfo($file2->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file2->getClientOriginalExtension();
                $file2->move($destination, $fileName2);
                $imagePath2 = 'services/' . $fileName2;
            }


            $service = Service::create([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'image' => $imagePath,
                'image_2' => $imagePath2,
                'status' => $request->status,
                'pin' => $request->pin,
            ]);

            return redirect()
                ->route('services-items')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Berhasil!',
                    'text' => 'Artikel berhasil disimpan!'
                ]);
        } catch (Exception $e) {
            Log::error('Gagal menyimpan artikel service: ' . $e->getMessage());
            if (!empty($imagePath) && File::exists(public_path('storage/' . $imagePath))) {
                File::delete(public_path('storage/' . $imagePath));
            }
            if (!empty($imagePath2) && File::exists(public_path('storage/' . $imagePath2))) {
                File::delete(public_path('storage/' . $imagePath2));
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
                ]);
        }
    }

    public function show_services_items($id)
    {
        try {
            $service = Service::findOrFail(decrypt($id));

            return response()->json([
                'title' => $service->title,
                'short_description' => $service->short_description,
                'description' => $service->description,
                'image' => $service->image,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Data tidak ditemukan atau ID tidak valid.',
            ], 404);
        }
    }

    public function edit_services_items($id)
    {
        try {
            $service = Service::findOrFail(decrypt($id));
            return view('LandingPage.admin.services-items.edit', compact('service'));
        } catch (\Exception $e) {
            return redirect()->route('admin.services-items.index')->with('error', 'Data tidak ditemukan.');
        }
    }

    public function updated_services_items(Request $request, $id)
    {
        try {
            $service = Service::findOrFail(decrypt($id));

            $request->validate([
                'title' => 'required|string|max:255',
                'short_description' => 'nullable|string',
                'description' => 'nullable|string',
                'status' => 'required|in:0,1',
                'pin' => 'required|in:0,1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            ]);

            $service->fill([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'status' => $request->status,
                'pin' => $request->pin,
            ]);

            $destination = public_path('storage/services');

            // Buat folder jika belum ada
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // Gambar utama
            if ($request->hasFile('image')) {
                $oldImagePath = public_path('storage/' . $service->image);
                if ($service->image && file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }

                $fileName = time() . '_1.' . $request->image->getClientOriginalExtension();
                $request->image->move($destination, $fileName);

                $service->image = 'services/' . $fileName;
            }

            // Gambar kedua
            if ($request->hasFile('image_2')) {
                $oldImagePath2 = public_path('storage/' . $service->image_2);
                if ($service->image_2 && file_exists($oldImagePath2)) {
                    @unlink($oldImagePath2);
                }

                $fileName2 = time() . '_2.' . $request->image_2->getClientOriginalExtension();
                $request->image_2->move($destination, $fileName2);

                $service->image_2 = 'services/' . $fileName2;
            }

            $service->save();

            return redirect()
                ->route('services-items')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Berhasil!',
                    'text' => 'Data berhasil diperbarui!'
                ]);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ]);
        }
    }
}
