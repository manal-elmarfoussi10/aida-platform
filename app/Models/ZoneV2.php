<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneV2 extends Model
{
    use HasFactory;

    protected $table = 'zones_v2';

    protected $fillable = [
        'name',
        'zone_type',
        'status',
        'occupancy',
        'temperature_humidity',
        'energy_usage',
    ];
}
