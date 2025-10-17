<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Service;
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
        $serviceItems = Service::where('status', 1)->get();

        return view('LandingPage.services', compact('highlight', 'features', 'images', 'serviceItems'));
    }

    public function services_items(Request $request, $id)
    {
        $id = decrypt($id);
        $serviceItems = Service::where('id', $id)->first();
        return view('LandingPage.service-article', compact('serviceItems'));
    }
}
