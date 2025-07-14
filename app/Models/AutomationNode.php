<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutomationNode extends Model
{
    use HasFactory;

    protected $fillable = [
        'automation_id',
        'type',
        'data',
        'x',
        'y',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function automation()
    {
        return $this->belongsTo(Automation::class);
    }

    // Connexions sortantes
    public function edgesFrom()
    {
        return $this->hasMany(AutomationEdge::class, 'source_node_id');
    }

    // Connexions entrantes
    public function edgesTo()
    {
        return $this->hasMany(AutomationEdge::class, 'target_node_id');
    }
}
