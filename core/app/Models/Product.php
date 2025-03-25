<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['campaign_id', 'product_name', 'price', 'quantity', 'total_cost', 'comments'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
