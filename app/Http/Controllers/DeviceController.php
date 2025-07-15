<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\ZoneV2;
use App\Models\Site;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices with optional filtering.
     */
    public function index(Request $request)
{
    $sites = Site::all();
    $selectedSiteId = $request->input('site_id');
    $selectedBuildingId = $request->input('building_id');
    $selectedFloorId = $request->input('floor_id');

    // Fetch buildings based on selected site
    $buildings = $selectedSiteId
        ? Building::where('site_id', $selectedSiteId)->get()
        : collect();

    // Fetch floors based on selected building
    $floors = $selectedBuildingId
        ? Floor::where('building_id', $selectedBuildingId)->get()
        : collect();

    // Devices query
    $devices = Device::with(['zoneV2.floor.building.site'])
        ->when($selectedFloorId, function ($query) use ($selectedFloorId) {
            $query->whereHas('zoneV2', function ($q) use ($selectedFloorId) {
                $q->where('floor_id', $selectedFloorId);
            });
        })
        ->when($selectedBuildingId && !$selectedFloorId, function ($query) use ($selectedBuildingId) {
            $query->whereHas('zoneV2.floor', function ($q) use ($selectedBuildingId) {
                $q->where('building_id', $selectedBuildingId);
            });
        })
        ->when($selectedSiteId && !$selectedBuildingId && !$selectedFloorId, function ($query) use ($selectedSiteId) {
            $query->whereHas('zoneV2.floor.building', function ($q) use ($selectedSiteId) {
                $q->where('site_id', $selectedSiteId);
            });
        })
        ->get();

    return view('devices.index', compact(
        'devices',
        'sites',
        'buildings',
        'floors',
        'selectedSiteId',
        'selectedBuildingId',
        'selectedFloorId'
    ));
}

    /**
     * Show the form for creating a new device.
     */
    public function create()
    {
        $sites = Site::all();
        $zones = ZoneV2::all(); // fallback

        return view('devices.create', compact('sites', 'zones'));
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

        Device::create($request->only(['device_name', 'device_type', 'zone_id', 'current_status']));

        return redirect()->route('devices.index')->with('success', 'Device created successfully.');
    }

    /**
     * Show the form for editing the specified device.
     */
    public function edit(Device $device)
    {
        $zones = ZoneV2::all();
        $sites = Site::all();

        return view('devices.edit', compact('device', 'zones', 'sites'));
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

        $device->update($request->only(['device_name', 'device_type', 'zone_id', 'current_status']));

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
     * Import devices from a CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        if (count($data) < 2) {
            return back()->withErrors(['csv_file' => 'CSV file is empty or missing headers.']);
        }

        $header = array_map('trim', $data[0]);
        unset($data[0]);

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);
            $zone = ZoneV2::where('name', $rowData['zone'])->first();
            if (!$zone) continue;

            Device::create([
                'device_name'    => $rowData['device_name'],
                'device_type'    => $rowData['device_type'],
                'zone_id'        => $zone->id,
                'current_status' => $rowData['current_status'],
            ]);
        }

        return redirect()->route('devices.index')->with('success', 'Devices imported successfully.');
    }

    // API: Get buildings for a given site
    public function getBuildings($siteId)
    {
        return Building::where('site_id', $siteId)->get();
    }

    // API: Get floors for a given building
    public function getFloors($buildingId)
    {
        return Floor::where('building_id', $buildingId)->get();
    }

    // API: Get zones for a given floor
    public function getZones($floorId)
    {
        return ZoneV2::where('floor_id', $floorId)->get();
    }
}