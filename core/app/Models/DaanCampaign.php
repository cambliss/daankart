<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\DaanProduct;
use App\Models\User;
use App\Models\Category;

class DaanCampaign extends Model {
    use GlobalStatus;
    protected $guarded = ['id','created_at','updated_at'];
    protected $appends = ['sections'];

    public function products()
    {
        return $this->hasMany(DaanProduct::class, 'campaign_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getSectionsAttribute()
    {
        return json_decode($this->attributes['page_json']);
    }

    
    public function donations()
    {
        return $this->hasMany(Donation::class, 'campaign_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'campaign_id', 'id');
    }
}

