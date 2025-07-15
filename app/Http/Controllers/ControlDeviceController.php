<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\Device;

class ControlDeviceController extends Controller
{
    public function index(Request $request)
{
    $zones = Zone::all();
    $zoneId = $request->input('zone_id') ?? $zones->first()?->id;
    $type = $request->input('device_type');

    $query = Device::where('zone_id', $zoneId);
    if ($type) {
        $query->where('type', $type);
    }

    $devices = $query->get();

    // DEBUG TEMPORAIRE
    // dd($zoneId, $type, $devices);

    return view('controls.index', compact('zones', 'zoneId', 'devices'));

}


public function update(Request $request, $id)
{
    $zone = ZoneV2::findOrFail($id);

    // Optional: Log incoming data for debugging
    \Log::info('Update request for zone ' . $id, $request->all());

    // Validate incoming data (optional but recommended)
    $request->validate([
        'temperature_humidity' => 'nullable|numeric|min:10|max:30',
        'shades' => 'nullable|integer|min:0|max:100',
        'dimmer' => 'nullable|integer|min:0|max:100',
        'color_temperature' => 'nullable|integer|min:1000|max:10000',
        'rgb_color' => 'nullable|string',
    ]);

    // Update the zone fields
    $zone->temperature_humidity = $request->input('temperature_humidity');
    $zone->shades = $request->input('shades');
    $zone->dimmer = $request->input('dimmer');
    $zone->color_temperature = $request->input('color_temperature');
    $zone->rgb_color = $request->input('rgb_color');

    $zone->save();

    return response()->json(['success' => true, 'message' => 'Zone updated successfully.']);
}

    public function updateDevice(Request $request, Device $device)
    {
        $settings = [];

        if ($device->type === 'thermostat') {
            $settings['temperature'] = $request->input('temperature');
        } elseif ($device->type === 'light') {
            $settings['dimmer'] = $request->input('dimmer');
            $settings['color_temperature'] = $request->input('color_temperature');
            $settings['rgb'] = $request->input('rgb');
        } elseif ($device->type === 'shade') {
            $settings['position'] = $request->input('position');
        }

        $device->settings = $settings;
        $device->save();

        return back()->with('success', 'Device updated successfully');
    }
}
