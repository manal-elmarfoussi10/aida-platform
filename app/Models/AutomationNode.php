<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutomationNode extends Model
{
    use HasFactory;

    protected $fillable = ['automation_id', 'type', 'data', 'x', 'y'];

    protected $casts = [
        'data' => 'array',
    ];

    public function automation()
    {
        return $this->belongsTo(Automation::class);
    }
}
