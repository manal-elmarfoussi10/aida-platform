<?php

namespace App\Http\Controllers;

use App\Models\NetworkDevice;
use Illuminate\Http\Request;

class NetworkDeviceController extends Controller
{
    public function index()
    {
        $devices = NetworkDevice::all();
        return view('network.index', compact('devices'));
    }

    public function toggle($id)
    {
        $device = NetworkDevice::findOrFail($id);
        $device->enabled = !$device->enabled;
        $device->save();

        return redirect()->back();
    }

    public function scan(Request $request)
    {
        try {
            set_time_limit(300); // pour éviter timeout

            $cmd = '"C:\\Program Files (x86)\\Nmap\\nmap.exe" -sn 192.168.1.0/24';
            $output = shell_exec($cmd);

            if ($output === null) {
                throw new \Exception("Nmap did not return any output.");
            }

            $lines = explode("\n", $output);
            $devices = [];
            $currentDevice = [];

            foreach ($lines as $line) {
                $line = trim($line);

                // IP address
                if (str_starts_with($line, "Nmap scan report for")) {
                    if (!empty($currentDevice)) {
                        $devices[] = $currentDevice;
                        $currentDevice = [];
                    }

                    if (preg_match('/for ([\d\.]+)/', $line, $matches)) {
                        $currentDevice['ip_address'] = $matches[1];
                    }
                }

                // Online status
                if (str_contains($line, 'Host is up')) {
                    $currentDevice['online_status'] = true;
                }

                // MAC address + Vendor
                if (str_contains($line, 'MAC Address:')) {
                    if (preg_match('/MAC Address: ([0-9A-F:]+) \((.*?)\)/i', $line, $matches)) {
                        $currentDevice['mac_address'] = $matches[1];
                        $currentDevice['device_name'] = $matches[2] ?: 'Unknown';
                    }
                }
            }

            // Ajouter le dernier device s’il existe
            if (!empty($currentDevice)) {
                $devices[] = $currentDevice;
            }

            $inserted = 0;
            foreach ($devices as $device) {
                if (!isset($device['mac_address'])) {
                    continue; // ignorer si pas d'adresse MAC
                }

                NetworkDevice::updateOrCreate(
                    ['mac_address' => $device['mac_address']],
                    [
                        'device_name' => $device['device_name'] ?? 'Unknown',
                        'type' => 'Unknown',
                        'serial_number' => 'SN-' . substr(str_replace(':', '', $device['mac_address']), -6),
                        'mac_address' => $device['mac_address'],
                        'ip_address' => $device['ip_address'] ?? null,
                        'firmware_version' => 'v1.0',
                        'online_status' => $device['online_status'] ?? false,
                        'enabled' => false,
                    ]
                );

                $inserted++;
            }

            return redirect()->route('network.index')->with('status', "Scan completed: $inserted device(s) updated.");
        } catch (\Exception $e) {
            return redirect()->route('network.index')->with('status', 'Scan failed: ' . $e->getMessage());
        }
    }
}
