<?php

namespace App\Http\Controllers\LandingPage;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Models\AboutUs;
use App\Models\Service;
use App\Models\ServiceHighlight;
use App\Models\ServiceHighlightFeature;
use App\Models\ServiceHighlightImage;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Traits\GeneralFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use App\Models\VisionMission;
use App\Models\AboutClient;
use App\Models\AboutFaq;
use App\Models\AboutHowWeWork;
use App\Models\Team;
use App\Models\AboutTestimonial;
use App\Models\AboutBestSelling;
use App\Models\AboutPage;

class AboutUsController extends Controller
{
    public function AboutPerusahaan(Request $request)
    {
        PermissionChecking(['view_aboutus', 'create_aboutus', 'edit_aboutus', 'delete_aboutus']);
        // dd($request->all());
        if ($request->ajax()) {
            $perusahaan = AboutUs::orderBy('created_at', 'desc')->get();
            // dd($perusahaan);
            return DataTables::of($perusahaan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($perusahaan) {
                    $id = encrypt($perusahaan->id);
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

                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['aksi', 'status', 'pin'])
                ->make(true);
        } else {
            $title = 'Perusahaan';
            $about = AboutUs::orderBy('created_at', 'desc')->first();
            // dd($about);
            return view('LandingPage.admin.aboutus.perusahaan.index', compact('title', 'about'));
        }
    }

    public function perusahaanStore(Request $request)
    {
        PermissionChecking(['view_aboutus', 'create_aboutus']);

        try {

            $about = AboutUs::first();
            // dd($about);
            // === PASTIKAN FOLDER TUJUAN ADA ===
            $destination = public_path('storage/aboutus');
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            // === HANDLE GAMBAR PERTAMA ===
            $imagePath = $about->image ?? null;
            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($about && $about->image && File::exists(public_path('storage/' . $about->image))) {
                    File::delete(public_path('storage/' . $about->image));
                }

                $file = $request->file('image');
                $fileName = time() . '_1_' . $file->getClientOriginalName();
                $file->move($destination, $fileName);
                $imagePath = 'aboutus/' . $fileName;
            }

            // === HANDLE GAMBAR KEDUA ===
            $imagePath2 = $about->image_2 ?? null;
            if ($request->hasFile('image_2')) {
                // Hapus gambar lama
                if ($about && $about->image_2 && File::exists(public_path('storage/' . $about->image_2))) {
                    File::delete(public_path('storage/' . $about->image_2));
                }

                $file2 = $request->file('image_2');
                $fileName2 = time() . '_2_' . $file2->getClientOriginalName();
                $file2->move($destination, $fileName2);
                $imagePath2 = 'aboutus/' . $fileName2;
            }

            // === SIMPAN / UPDATE DENGAN updateOrCreate ===
            AboutUs::updateOrCreate(
                ['id' => $about->id ?? null],
                [
                    'company_name' => $request->company_name,
                    'tagline' => $request->tagline,
                    'description' => $request->description,
                    'founded_year' => $request->founded_year,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'website' => $request->website,
                    'image' => $imagePath,
                    'image_2' => $imagePath2,
                    'status' => $request->status,
                ]
            );

            return redirect()->back()->with([
                'swal' => [
                    'icon' => 'success',
                    'title' => 'Success!',
                    'text' => $about ? 'Data updated successfully!' : 'Data created successfully!',
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('AboutUs storeOrUpdate error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with([
                'swal' => [
                    'icon' => 'error',
                    'title' => 'Error!',
                    'text' => 'An unexpected error occurred while saving data.',
                ],
            ]);
        }
    }
}
