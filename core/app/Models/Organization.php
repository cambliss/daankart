<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $casts = [
        'address' => 'object',
    ];

    public function awards()
    {
        return $this->hasMany(OrganizationAward::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orgUpdates()
    {
        return $this->hasMany(OrganizationUpdate::class);
    }

    public function donors()
    {
        return $this->hasMany(OrganizationDonor::class);
    }
}
