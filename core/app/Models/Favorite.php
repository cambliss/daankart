<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
    function scopeUser($query, $userId)
    {
        $query->where('user_id', $userId);
    }
}
