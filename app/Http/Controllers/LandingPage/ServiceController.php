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

        return view('LandingPage.admin.services.index', compact('highlight'));
    }

    public function store(Request $request)
    {
        PermissionChecking(['create_service', 'edit_service']);

        $request->validate([
            'id' => 'nullable|exists:service_highlights,id',
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'description' => 'required|string',
            'features.*.icon' => 'nullable|string|max:255',
            'features.*.title' => 'required|string|max:255',
            'features.*.description' => 'nullable|string',
            'image_1' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'image_2' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'image_3' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'image_4' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // Cek apakah ini update atau create
            $highlight = ServiceHighlight::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'title' => $request->title,
                    'sub_title' => $request->sub_title,
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

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Data Service Highlight berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
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
