<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id', 'device_type', 'device_name', 'current_status', 'manual_control', 'last_active',
    ];

    public function zone()
    {
        return $this->belongsTo(ZoneV2::class, 'zone_id');
    }
}