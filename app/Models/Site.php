<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['name', 'city', 'image_url'];

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
