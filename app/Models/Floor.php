<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = ['name', 'building_id', 'level', 'area'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function zones()
    {
        return $this->hasMany(ZoneV2::class, 'floor_id');
    }
}
