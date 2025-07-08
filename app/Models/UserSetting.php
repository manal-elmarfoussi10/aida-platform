<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = ['user_id', 'location', 'language', 'notifications', 'dark_mode'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
