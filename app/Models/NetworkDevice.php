<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetworkDevice extends Model
{
    protected $fillable = [
        'device_name',
        'type',
        'serial_number',
        'mac_address',
        'ip_address',
        'firmware_version',
        'online_status',
        'enabled',
    ];
}


