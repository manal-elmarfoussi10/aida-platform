<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Building;
use App\Models\Floor;
use App\Models\ZoneV2;
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
        $zones = $selectedFloorId ? ZoneV2::where('floor_id', $selectedFloorId)->get() : collect();

        return view('hierarchy.index', compact(
            'sites', 'buildings', 'floors', 'zones',
            'selectedSiteId', 'selectedBuildingId', 'selectedFloorId'
        ));
    }
}