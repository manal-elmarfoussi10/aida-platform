<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;
use App\Models\ControlDevice;

class ControlDeviceSeeder extends Seeder
{
    public function run(): void
    {
        $zone = Zone::first() ?? Zone::create(['name' => 'Zone A']);

        ControlDevice::create([
            'zone_id' => $zone->id,
            'type' => 'thermostat',
            'settings' => ['temperature' => 22],
        ]);

        ControlDevice::create([
            'zone_id' => $zone->id,
            'type' => 'light',
            'settings' => [
                'dimmer' => 60,
                'color_temperature' => 3500,
                'rgb' => '#ffaa00',
            ],
        ]);

        ControlDevice::create([
            'zone_id' => $zone->id,
            'type' => 'shade',
            'settings' => ['position' => 50],
        ]);
    }
}
