<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = ['name', 'site_id', 'area', 'type'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }
}
