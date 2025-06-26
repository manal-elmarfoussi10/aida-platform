<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'action', 'scheduled_at'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
