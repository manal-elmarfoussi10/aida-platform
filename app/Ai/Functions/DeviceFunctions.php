<?php

namespace App\Ai\Functions;

use App\Models\Device;

class DeviceFunctions
{
    public static function countDevices()
    {
        return 'There are ' . Device::count() . ' devices in the system.';
    }

    public static function listAllDevices()
    {
        return 'Devices: ' . Device::pluck('name')->implode(', ');
    }
  
    public static function updateDeviceFieldByName($deviceName, $field, $value)
{
    $device = \App\Models\Device::where('device_name', $deviceName)->first();

    if (!$device) {
        return "❌ Device \"$deviceName\" not found.";
    }

    $allowedFields = [
        'temperature', 'dimmer', 'color_temperature', 
        'rgb_color', 'shades', 'current_status', 'manual_control'
    ];

    $aliases = [
        'color' => 'rgb_color',
        'brightness' => 'dimmer',
        'status' => 'current_status',
    ];

    $normalizedField = $aliases[$field] ?? $field;

    if (!in_array($normalizedField, $allowedFields)) {
        return "⚠️ \"$field\" is not a valid field I can update.";
    }

    $device->$normalizedField = is_numeric($value) ? (float)$value : $value;
    $device->save();

    return "✅ \"$normalizedField\" of device \"$deviceName\" updated to \"$value\".";
}
}