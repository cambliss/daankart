<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignProduct extends Model
{
    protected $table = 'campaigns_products';

    protected $fillable = [
        'campaign_id',
        'product_id',
        'quantity',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the campaign that owns the campaign product.
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the product that owns the campaign product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to only include active records.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive records.
     */
    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }

    /**
     * Get the total price for this campaign product
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->product->unit_price;
    }

    /**
     * Check if the product has enough available units
     */
    public function hasEnoughUnits(): bool
    {
        return $this->product->unit_available >= $this->quantity;
    }
} 