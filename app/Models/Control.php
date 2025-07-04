<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ZoneV2;
use App\Models\Device;

class Control extends Model
{
    protected $fillable = [
        'zone_id',
        'device_id',
        'control_type',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function zone()
    {
        return $this->belongsTo(ZoneV2::class, 'zone_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}