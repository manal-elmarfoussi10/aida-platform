<?php

namespace App\Ai\Services;

use App\Ai\Functions\ZoneFunctions;

class ZoneService
{
    public static function handleQuery($query)
    {
        $query = strtolower($query);

        if (str_contains($query, 'how many zones')) {
            return ZoneFunctions::countZones();
        }

        if (str_contains($query, 'list all zones')) {
            return ZoneFunctions::listAllZones();
        }

        if (str_contains($query, 'status of zone')) {
            preg_match('/status of zone ([a-z0-9]+)/', $query, $matches);
            return isset($matches[1]) ? ZoneFunctions::getZoneStatus(strtoupper($matches[1])) : null;
        }

        return null;
    }
}