<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\ZoneV2;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices.
     */
    public function index()
    {
        $devices = Device::with('zoneV2')->get();// Ensure zone() relationship is defined
        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new device.
     */
    public function create()
    {
        $zones = ZoneV2::all();
        return view('devices.create', compact('zones'));
    }

    /**
     * Store a newly created device in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_name'     => 'required|string|max:255',
            'device_type'     => 'required|string|max:255',
            'zone_id'         => 'required|exists:zones_v2,id',
            'current_status'  => 'required|boolean',
        ]);

        Device::create([
            'device_name'     => $request->device_name,
            'device_type'     => $request->device_type,
            'zone_id'         => $request->zone_id,
            'current_status'  => $request->current_status,
        ]);

        return redirect()->route('devices.index')->with('success', 'Device created successfully.');
    }

    /**
     * Show the form for editing the specified device.
     */
    public function edit(Device $device)
    {
        $zones = ZoneV2::all();
        return view('devices.edit', compact('device', 'zones'));
    }

    /**
     * Update the specified device in storage.
     */
    public function update(Request $request, Device $device)
    {
        $request->validate([
            'device_name'     => 'required|string|max:255',
            'device_type'     => 'required|string|max:255',
            'zone_id'         => 'required|exists:zones_v2,id',
            'current_status'  => 'required|boolean',
        ]);

        $device->update([
            'device_name'     => $request->device_name,
            'device_type'     => $request->device_type,
            'zone_id'         => $request->zone_id,
            'current_status'  => $request->current_status,
        ]);

        return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified device from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
    }
    /**
 * Display the specified device.
 */
public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('csv_file');
    $path = $file->getRealPath();

    $header = null;
    $data = array_map('str_getcsv', file($path));

    if (count($data) < 1) {
        return back()->withErrors(['csv_file' => 'CSV file is empty.']);
    }

    $header = array_map('trim', $data[0]);
    unset($data[0]); // remove header row

    foreach ($data as $row) {
        $rowData = array_combine($header, $row);

        $zone = ZoneV2::where('name', $rowData['zone'])->first();

        if (!$zone) continue;

        Device::create([
            'device_name'     => $rowData['device_name'],
            'device_type'     => $rowData['device_type'],
            'current_status'  => $rowData['current_status'],
            'zone_id'         => $zone->id,
        ]);
    }

    return redirect()->route('devices.index')->with('success', 'Devices imported successfully.');
}

}