<?php

namespace App\Ai\Functions;

use App\Models\ZoneV2;

class ZoneFunctions
{
    public static function countZones()
    {
        return 'There are ' . ZoneV2::count() . ' zones in the building.';
    }

    public static function listAllZones()
    {
        return 'Zones: ' . ZoneV2::pluck('name')->implode(', ');
    }

    public static function getZoneStatus($zoneName)
    {
        $zone = ZoneV2::where('name', $zoneName)->first();
        return $zone ? "Zone {$zoneName} status: {$zone->status}" : "Zone {$zoneName} not found.";
    }
}