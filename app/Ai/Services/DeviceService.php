<?php

namespace App\Ai\Services;

use App\Ai\Functions\DeviceFunctions;

class DeviceService
{
    public static function handleQuery($query)
    {
        $query = strtolower($query);

        // ✅ Match and update any field
        if (preg_match('/set (.+?) (?:of|for) device (.+?) to (.+)/i', $query, $matches)) {
            $field = trim($matches[1]);
            $deviceName = trim($matches[2]);
            $value = trim($matches[3]);

            return DeviceFunctions::updateDeviceFieldByName($deviceName, $field, $value);
        }

        // ✅ Other device-related queries
        if (str_contains($query, 'how many devices')) {
            return DeviceFunctions::countDevices();
        }

        if (str_contains($query, 'list all devices')) {
            return DeviceFunctions::listAllDevices();
        }

        // Add more natural language queries here as needed

        return null; // fallback if nothing matches
    }
}