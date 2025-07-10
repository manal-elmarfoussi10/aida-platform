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
        'floor_id',
    ];

    public function devices()
{
    return $this->hasMany(Device::class, 'zone_id');
}
public function configurations()
{
    return $this->belongsToMany(\App\Models\Configuration::class, 'configuration_zone', 'zone_id', 'configuration_id');
}
public function floor()
{
    return $this->belongsTo(Floor::class);
}


}
