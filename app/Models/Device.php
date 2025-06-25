<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'zone', 'device_type', 'device_name', 'current_status', 'manual_control'
    ];
}
