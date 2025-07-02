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
