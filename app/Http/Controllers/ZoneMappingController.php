<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\ZoneV2;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ZoneMappingController extends Controller
{
    /**
     * Display a listing of the devices with optional zone filtering.
     */
    public function index(Request $request)
    {
        $zone = $request->get('zone');
        $type = $request->get('type');
    
        $query = Device::query();
    
        if ($zone) {
            $query->whereHas('zone', function ($q) use ($zone) {
                $q->where('name', $zone);
            });
        }
    
        if ($type) {
            $query->where('device_type', $type);
        }
    
        $devices = $query->paginate(10);
        $zones = ZoneV2::all();
    
        return view('zone-mapping.index', compact('devices', 'zones', 'zone', 'type'));
    }

    /**
     * Update the device-zone mapping.
     */
    public function update(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'zonev2_id' => 'required|exists:zone_v2,id',
        ]);

        $device = Device::findOrFail($request->input('device_id'));
        $device->zonev2_id = $request->input('zonev2_id');
        $device->save();

        return redirect()->back()->with('success', 'Device zone updated successfully.');
    }

    /**
     * Export device-zone mapping to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $zone = $request->get('zone');

        $query = Device::query();

        if ($zone) {
            $query->whereHas('zone', function ($q) use ($zone) {
                $q->where('name', $zone);
            });
        }

        $devices = $query->with('zone')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="device-zone-mapping.csv"',
        ];

        $columns = ['Device Name', 'Zone Name'];

        $callback = function () use ($devices, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($devices as $device) {
                fputcsv($file, [
                    $device->name,
                    $device->zone ? $device->zone->name : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}