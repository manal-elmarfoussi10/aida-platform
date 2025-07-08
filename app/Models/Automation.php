<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Automation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'configuration_id'];

    public function nodes()
    {
        return $this->hasMany(AutomationNode::class);
    }

    public function edges()
    {
        return $this->hasMany(AutomationEdge::class);
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }
    public function zone()
{
    return $this->belongsTo(ZoneV2::class, 'zonev2_id');
}
}
