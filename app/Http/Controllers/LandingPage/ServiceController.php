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
