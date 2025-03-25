<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Traits\GlobalStatus;

class Category extends Model
{
    use GlobalStatus;

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function stories()
    {
        return $this->hasMany(SuccessStory::class);
    }

    public function scopeHasCampaigns($query)
    {
        return $query->whereHas('campaigns', function ($q) {
            $q->active()->running()->boundary();
        });
    }
}
