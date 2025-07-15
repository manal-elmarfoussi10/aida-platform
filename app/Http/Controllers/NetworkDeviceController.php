<?php

namespace App\Http\Controllers;

use App\Models\NetworkDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NetworkDeviceController extends Controller
{
    public function index(Request $request)
    {
        $devices = NetworkDevice::all(); // DB devices
    
        // Merge live scan if exists
        if (session('scan_results')) {
            $devices = $devices->concat(collect(session('scan_results')));
        }
    
        return view('network.index', compact('devices'));
    }

    public function toggle($id)
    {
        $device = NetworkDevice::findOrFail($id);
        $device->enabled = !$device->enabled;
        $device->save();

        return redirect()->back();
    }

    public function createFromQr(Request $request)
{
    $raw = $request->input('qr_data');

    // Attempt to decode
    $data = json_decode($raw, true);

    if (!$data || !is_array($data)) {
        return redirect()->back()->with('status', 'QR code data is not valid JSON.');
    }

    // Validate required fields
    $validator = Validator::make($data, [
        'device_name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'serial' => 'required|string|max:255',
        'mac' => 'required|string|max:255|unique:network_devices,mac_address',
        'ip' => 'required|ip',
        'firmware' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->with('status', 'Invalid QR data: ' . implode(', ', $validator->errors()->all()));
    }

    // Save device
    NetworkDevice::create([
        'device_name' => $data['device_name'],
        'type' => $data['type'],
        'serial_number' => $data['serial'],
        'mac_address' => $data['mac'],
        'ip_address' => $data['ip'],
        'firmware_version' => $data['firmware'],
        'online_status' => true,
        'enabled' => true,
    ]);

    return redirect()->route('network.index')->with('status', '✅ Device created successfully from QR.');
}

public function scan(Request $request)
{
    try {
        $output = [];
        exec("arp -a", $output);

        foreach ($output as $line) {
            // Try to extract IP and MAC
            if (preg_match('/\(([\d.]+)\)\s+at\s+([a-fA-F0-9:]+)/', $line, $matches)) {
                $ip = $matches[1];
                $mac = strtoupper($matches[2]);

                // Avoid duplicates based on MAC
                $device = NetworkDevice::firstOrCreate(
                    ['mac_address' => $mac],
                    [
                        'device_name' => 'Discovered ' . Str::random(5),
                        'type' => 'Unknown',
                        'serial_number' => 'SN-' . Str::random(6),
                        'ip_address' => $ip,
                        'firmware_version' => 'v1.0.0',
                        'online_status' => true,
                        'enabled' => true,
                    ]
                );

                // Update IP if it changed
                $device->ip_address = $ip;
                $device->online_status = true;
                $device->save();
            }
        }

        return redirect()->route('network.index')->with('status', 'Network scan complete.');
    } catch (\Exception $e) {
        return redirect()->route('network.index')->withErrors(['Scan failed: ' . $e->getMessage()]);
    }
}

}
