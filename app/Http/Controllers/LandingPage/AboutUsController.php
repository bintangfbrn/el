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

use App\Models\AboutVisionMission;
use App\Models\AboutClient;
use App\Models\AboutFaq;
use App\Models\AboutHowWeWork;
use App\Models\AboutTeam;
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
            $serviceItems = AboutUs::orderBy('created_at', 'desc')->get();

            return view('LandingPage.admin.aboutus.perusahaan.index', compact('title', 'serviceItems'));
        }
    }
}
