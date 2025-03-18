<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\DaanProduct;
use App\Models\User;

class DaanCampaign extends Model {
    use GlobalStatus;
    protected $guarded = ['id','created_at','updated_at'];

    public function products()
    {
        return $this->hasMany(DaanProduct::class, 'campaign_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

