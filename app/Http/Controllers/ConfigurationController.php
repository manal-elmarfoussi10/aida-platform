<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\ZoneV2;
use App\Models\Site;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index(Request $request)
    {
        $sites = Site::all();
        $selectedSiteId = $request->input('site_id');
        $selectedBuildingId = $request->input('building_id');
        $selectedFloorId = $request->input('floor_id');
    
        $buildings = $selectedSiteId
            ? Building::where('site_id', $selectedSiteId)->get()
            : collect();
    
        $floors = $selectedBuildingId
            ? Floor::where('building_id', $selectedBuildingId)->get()
            : collect();
    
        $configs = Configuration::with('zones.floor.building.site')
            ->when($selectedFloorId, function ($query) use ($selectedFloorId) {
                $query->whereHas('zones', function ($q) use ($selectedFloorId) {
                    $q->where('floor_id', $selectedFloorId);
                });
            })
            ->when($selectedBuildingId && !$selectedFloorId, function ($query) use ($selectedBuildingId) {
                $query->whereHas('zones.floor', function ($q) use ($selectedBuildingId) {
                    $q->where('building_id', $selectedBuildingId);
                });
            })
            ->when($selectedSiteId && !$selectedBuildingId && !$selectedFloorId, function ($query) use ($selectedSiteId) {
                $query->whereHas('zones.floor.building', function ($q) use ($selectedSiteId) {
                    $q->where('site_id', $selectedSiteId);
                });
            })
            ->get();
    
        return view('configurations.index', compact(
            'configs',
            'sites',
            'buildings',
            'floors',
            'selectedSiteId',
            'selectedBuildingId',
            'selectedFloorId'
        ));
    }

    public function create()
    {
        $sites = Site::all();
        return view('configurations.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'type'     => 'required|string',
            'mode'     => 'required|string',
            'zones'    => 'required|array',
            'zones.*'  => 'exists:zones_v2,id',
        ]);

        $config = Configuration::create([
            'name' => $request->name,
            'type' => $request->type,
            'mode' => $request->mode,
        ]);

        $config->zones()->sync($request->zones);

        return redirect()->route('configurations.index')->with('success', 'Configuration created!');
    }

    public function edit(Configuration $configuration)
    {
        $sites = Site::all();
        $zones = ZoneV2::all();
        return view('configurations.edit', compact('configuration', 'zones', 'sites'));
    }

    public function update(Request $request, Configuration $configuration)
    {
        $request->validate([
            'name'     => 'required|string',
            'type'     => 'required|string',
            'mode'     => 'required|string',
            'zones'    => 'required|array',
            'zones.*'  => 'exists:zones_v2,id',
        ]);

        $configuration->update($request->only(['name', 'type', 'mode']));

        $configuration->zones()->sync($request->zones);

        return redirect()->route('configurations.index')->with('success', 'Configuration updated!');
    }

    public function destroy(Configuration $configuration)
    {
        $configuration->zones()->detach();
        $configuration->delete();

        return redirect()->route('configurations.index')->with('success', 'Configuration deleted!');
    }

    // AJAX: Get buildings by site
    public function getBuildings($siteId)
    {
        return response()->json(
            Building::where('site_id', $siteId)->get()
        );
    }

    // AJAX: Get floors by building
    public function getFloors($buildingId)
    {
        return response()->json(
            Floor::where('building_id', $buildingId)->get()
        );
    }

    // AJAX: Get zones by floor
    public function getZones($floorId)
    {
        return response()->json(
            ZoneV2::where('floor_id', $floorId)->get()
        );
    }
}