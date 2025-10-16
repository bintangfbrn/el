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
        $highlight = ServiceHighlight::with(['features', 'images'])->first();
        $features = $highlight ? $highlight->features : collect();
        $images = $highlight ? $highlight->images : collect();

        return view('LandingPage.services', compact('highlight', 'features', 'images'));
    }
}
