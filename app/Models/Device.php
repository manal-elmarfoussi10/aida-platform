<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'device_type',
        'device_name',
        'current_status',
        'manual_control',
        'last_active',
        'temperature',
        'dimmer',
        'color_temperature',
        'rgb_color',
        'shades', 
    ];

    public function zoneV2()
    {
        return $this->belongsTo(ZoneV2::class, 'zone_id');
    }

}