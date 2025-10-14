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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        PermissionChecking(['view_service', 'create_service', 'edit_service', 'delete_service']);
        $highlight = ServiceHighlight::with(['features', 'images'])->first();
        $images = ServiceHighlightImage::where('highlight_id', $highlight->id)->get();

        return view('LandingPage.admin.services.index', compact('highlight', 'images'));
    }

    public function store(Request $request)
    {
        PermissionChecking(['create_service', 'edit_service']);

        // Show confirmation before saving (optional - if you want confirmation on form submit)
        // This would require additional JavaScript on the form submit

        DB::beginTransaction();

        try {
            // Cek apakah ini update atau create
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

            // Upload image_1 sampai image_4
            for ($i = 1; $i <= 4; $i++) {
                $field = 'image_' . $i;
                if ($request->hasFile($field)) {
                    // Hapus file lama jika ada
                    if ($highlight->$field && Storage::disk('public')->exists($highlight->$field)) {
                        Storage::disk('public')->delete($highlight->$field);
                    }

                    $path = $request->file($field)->store('services', 'public');
                    $highlight->$field = $path;
                }
            }

            $highlight->save();

            // Update Features - hapus yang lama dulu
            $highlight->features()->delete();

            if ($request->has('features')) {
                foreach ($request->features as $feature) {
                    if (!empty($feature['title'])) { // Hanya simpan jika title tidak kosong
                        ServiceHighlightFeature::create([
                            'highlight_id' => $highlight->id,
                            'icon' => $feature['icon'] ?? null,
                            'title' => $feature['title'],
                            'description' => $feature['description'] ?? null,
                        ]);
                    }
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    // Skip jika file kosong
                    if (!$file || !$file->isValid()) continue;

                    $path = $file->store('services/gallery', 'public');

                    // Cari image berdasarkan index/position
                    $existingImage = $highlight->images->get($index);

                    if ($existingImage) {
                        // Update image yang sudah ada
                        $existingImage->update([
                            'image_path' => $path
                        ]);
                    } else {
                        // Buat baru jika belum ada
                        ServiceHighlightImage::create([
                            'highlight_id' => $highlight->id,
                            'image_path' => $path,
                        ]);
                    }
                }
            }

            DB::commit();

            // SweetAlert success message with Yes/No style options
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

            // SweetAlert error message
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

    public function edit($id)
    {
        PermissionChecking(['edit_service']);
        $data = Service::findOrFail(decrypt($id));
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        PermissionChecking(['edit_service']);

        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:services,slug,' . $id,
        ]);

        try {
            $data = Service::findOrFail($id);
            $data->update($request->all());
            GeneralFunction::toastr('success', 'Berhasil!', 'Data Service berhasil diupdate!');
            return redirect()->route('service.index');
        } catch (Exception $e) {
            Log::error("[ServiceController@update] Error: {$e->getMessage()}");
            GeneralFunction::toastr('error', 'Gagal!', 'Gagal mengupdate service.');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        PermissionChecking(['delete_service']);
        try {
            $id = decrypt($id);
            Service::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Service berhasil dihapus']);
        } catch (Exception $e) {
            Log::error("[ServiceController@destroy] Error: {$e->getMessage()}");
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    }
}
