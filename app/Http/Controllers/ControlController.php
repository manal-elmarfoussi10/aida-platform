<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoneV2;
use App\Models\Device;
use App\Models\Site;
use App\Models\Building;
use App\Models\Floor;

class ControlController extends Controller
{
    public function index(Request $request)
{
    $selectedSiteId = $request->input('site_id') ?? \App\Models\Site::first()?->id;
    $selectedBuildingId = $request->input('building_id') ?? 
        ($selectedSiteId ? \App\Models\Building::where('site_id', $selectedSiteId)->first()?->id : null);
    $selectedFloorId = $request->input('floor_id') ?? 
        ($selectedBuildingId ? \App\Models\Floor::where('building_id', $selectedBuildingId)->first()?->id : null);
    $selectedZoneId = $request->input('zone_id') ?? 
        ($selectedFloorId ? ZoneV2::where('floor_id', $selectedFloorId)->first()?->id : null); // ✅ fixed here

    $sites = \App\Models\Site::all();
    $buildings = $selectedSiteId ? \App\Models\Building::where('site_id', $selectedSiteId)->get() : collect();
    $floors = $selectedBuildingId ? \App\Models\Floor::where('building_id', $selectedBuildingId)->get() : collect();
    $zones = $selectedFloorId ? ZoneV2::where('floor_id', $selectedFloorId)->get() : collect(); // ✅ also fixed

    $devices = \App\Models\Device::all();
    $device = $devices->first();

    return view('controls.index', compact(
        'sites', 'buildings', 'floors', 'zones',
        'selectedSiteId', 'selectedBuildingId', 'selectedFloorId', 'selectedZoneId',
        'devices', 'device'
    ));
}

    public function controls($id = null)
    {
        $devices = Device::all();
        $device = $id ? Device::findOrFail($id) : $devices->first();
    
        // Filters
        $selectedSiteId = request()->input('site_id') ?? \App\Models\Site::first()?->id;
        $selectedBuildingId = request()->input('building_id') ?? 
            ($selectedSiteId ? \App\Models\Building::where('site_id', $selectedSiteId)->first()?->id : null);
        $selectedFloorId = request()->input('floor_id') ?? 
            ($selectedBuildingId ? \App\Models\Floor::where('building_id', $selectedBuildingId)->first()?->id : null);
        $selectedZoneId = request()->input('zone_id') ?? 
            ($selectedFloorId ? \App\Models\Zone::where('floor_id', $selectedFloorId)->first()?->id : null);
    
        $sites = \App\Models\Site::all();
        $buildings = $selectedSiteId ? \App\Models\Building::where('site_id', $selectedSiteId)->get() : collect();
        $floors = $selectedBuildingId ? \App\Models\Floor::where('building_id', $selectedBuildingId)->get() : collect();
        $zones = $selectedFloorId ? \App\Models\Zone::where('floor_id', $selectedFloorId)->get() : collect();
    
        return view('controls.index', compact(
            'devices', 'device',
            'sites', 'buildings', 'floors', 'zones',
            'selectedSiteId', 'selectedBuildingId', 'selectedFloorId', 'selectedZoneId'
        ));
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $device->update([
            'temperature' => $request->input('temperature'),
            'dimmer' => $request->input('dimmer'),
            'color_temperature' => $request->input('color_temperature'),
            'rgb_color' => $request->input('rgb_color'),
            'shades' => $request->input('shades'),
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $devices = Device::all();
        $device = Device::findOrFail($id);

        return view('controls.index', compact('devices', 'device'));
    }
}