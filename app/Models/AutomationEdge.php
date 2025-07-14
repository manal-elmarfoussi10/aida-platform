<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutomationEdge extends Model
{
    use HasFactory;

    protected $fillable = [
        'automation_id',
        'source_node_id',
        'target_node_id',
        'label',
    ];

    public function automation()
    {
        return $this->belongsTo(Automation::class);
    }

    // Nœud source
    public function sourceNode()
    {
        return $this->belongsTo(AutomationNode::class, 'source_node_id');
    }

    // Nœud cible
    public function targetNode()
    {
        return $this->belongsTo(AutomationNode::class, 'target_node_id');
    }
}
