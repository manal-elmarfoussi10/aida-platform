<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Building;
use App\Models\Floor;
use App\Models\ZoneV2;

class ControlController extends Controller
{
    public function index(Request $request)
    {
        $sites = Site::all();
        $selectedSiteId = $request->input('site_id') ?? $sites->first()?->id;

        $buildings = Building::where('site_id', $selectedSiteId)->get();
        $selectedBuildingId = $request->input('building_id');
        if (!$buildings->pluck('id')->contains($selectedBuildingId)) {
            $selectedBuildingId = $buildings->first()?->id;
        }

        $floors = Floor::where('building_id', $selectedBuildingId)->get();
        $selectedFloorId = $request->input('floor_id');
        if (!$floors->pluck('id')->contains($selectedFloorId)) {
            $selectedFloorId = $floors->first()?->id;
        }

        $zones = ZoneV2::where('floor_id', $selectedFloorId)->get();
        $selectedZoneId = $request->input('zone_id');
        if (!$zones->pluck('id')->contains($selectedZoneId)) {
            $selectedZoneId = $zones->first()?->id;
        }

        $zone = $zones->where('id', $selectedZoneId)->first();

        return view('controls.index', compact(
            'sites', 'buildings', 'floors', 'zones',
            'selectedSiteId', 'selectedBuildingId', 'selectedFloorId', 'selectedZoneId', 'zone'
        ));
    }

    public function update(Request $request, $id)
{
    try {
        \Log::info("Received update for zone ID: $id", $request->all());

        $zone = ZoneV2::findOrFail($id);

        $zone->temperature_humidity = $request->input('temperature_humidity');
        $zone->shades = $request->input('shades');
        $zone->dimmer = $request->input('dimmer');
        $zone->color_temperature = $request->input('color_temperature');
        $zone->rgb_color = $request->input('rgb_color');

        $zone->save();

        return response()->json(['success' => true, 'message' => 'Zone updated successfully.']);
    } catch (\Throwable $e) {
        \Log::error("Zone update failed", ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'Update failed', 'error' => $e->getMessage()], 500);
    }
}

    public function show($id)
    {
        return $this->index(request()->merge(['zone_id' => $id]));
    }
}