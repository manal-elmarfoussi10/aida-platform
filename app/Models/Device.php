<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $casts = [
        'zones' => 'array',
    ];

    // Relation : chaque device appartient à une zone
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}

