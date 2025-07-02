<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Zone;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ZoneMappingController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $zone = $request->input('zone');

        $query = Device::with('zone');

        if ($type) {
            $query->where('device_type', $type);
        }

        if ($zone) {
            $query->whereHas('zone', function ($q) use ($zone) {
                $q->where('name', $zone);
            });
        }

        $devices = $query->paginate(10);
        $zones = Zone::all();

        return view('zone-mapping.index', compact('devices', 'zones', 'type', 'zone'));
    }

    public function update(Request $request)
    {
        foreach ($request->devices as $deviceId => $zoneId) {
            $device = Device::find($deviceId);
            if ($device) {
                $device->zone_id = $zoneId;
                $device->save();
            }
        }

        return redirect()->route('map-zones.index')->with('success', 'Devices updated successfully!');
    }

    public function export(Request $request)
    {
        $type = $request->input('type');
        $zone = $request->input('zone');

        $query = Device::with('zone');

        if ($type) {
            $query->where('device_type', $type);
        }

        if ($zone) {
            $query->whereHas('zone', function ($q) use ($zone) {
                $q->where('name', $zone);
            });
        }

        $devices = $query->get();

        $response = new StreamedResponse(function () use ($devices) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Device Name', 'Type', 'Zone']);

            foreach ($devices as $device) {
                fputcsv($handle, [
                    $device->device_name,
                    $device->device_type,
                    $device->zone ? $device->zone->name : 'Unassigned'
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="devices.csv"');

        return $response;
    }
}
