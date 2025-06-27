<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['name', 'type', 'mode']; // ⚠️ PAS 'zones'

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'configuration_zone');
    }
}
