<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\ServiceHighlight;
use App\Models\ServiceHighlightImage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index_services()
    {
        // PermissionChecking(['view_service', 'create_service', 'edit_service', 'delete_service']);
        $highlight = ServiceHighlight::with(['features', 'images'])->first();

        $images = $highlight ? ServiceHighlightImage::where('highlight_id', $highlight->id)->get() : collect();

        return view('LandingPage.services', compact('highlight', 'images'));
    }
}
