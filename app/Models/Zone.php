<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [
        'name',
        'comfort_status',
        'energy_usage',
        'device_type',
        'maintenance_alert',
        'device_control_status',
    ];
}