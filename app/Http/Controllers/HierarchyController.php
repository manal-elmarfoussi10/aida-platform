<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Zone;
use Illuminate\Http\Request;

class HierarchyController extends Controller
{
    public function index(Request $request)
    {
        $sites = Site::all();
        $selectedSiteId = $request->input('site_id') ?? $sites->first()?->id;
        $buildings = Building::where('site_id', $selectedSiteId)->get();

        $selectedBuildingId = $request->input('building_id') ?? $buildings->first()?->id;
        $floors = Floor::where('building_id', $selectedBuildingId)->get();

        $selectedFloorId = $request->input('floor_id');
        $zones = $selectedFloorId ? Zone::where('floor_id', $selectedFloorId)->get() : [];

        return view('hierarchy.index', compact(
            'sites', 'buildings', 'floors', 'zones',
            'selectedSiteId', 'selectedBuildingId', 'selectedFloorId'
        ));
    }
}