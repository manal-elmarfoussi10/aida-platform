<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ControlDevice extends Model
{
    protected $fillable = ['zone_id', 'type', 'settings'];
    protected $casts = ['settings' => 'array'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
