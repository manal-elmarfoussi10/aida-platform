<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['name', 'type', 'mode'];

    /**
     * The zones that belong to this configuration.
     */
    public function zones()
    {
        return $this->belongsToMany(\App\Models\ZoneV2::class, 'configuration_zone', 'configuration_id', 'zone_id');
    }
}