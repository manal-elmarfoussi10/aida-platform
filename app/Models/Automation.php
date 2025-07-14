<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Automation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'configuration_id',
        'zonev2_id',
    ];

    /**
     * Tous les nœuds (nodes) liés à cette automatisation.
     */
    public function nodes()
    {
        return $this->hasMany(AutomationNode::class);
    }

    /**
     * Tous les liens (edges) entre les nœuds.
     */
    public function edges()
    {
        return $this->hasMany(AutomationEdge::class);
    }

    /**
     * Configuration associée à cette automatisation (optionnel).
     */
    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }

    /**
     * Zone associée à cette automatisation.
     */
    public function zone()
    {
        return $this->belongsTo(ZoneV2::class, 'zonev2_id');
    }
}
