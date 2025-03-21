<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class SuccessStory extends Model
{
    protected $casts = [
        'seo_content'=>'object'
    ];
  
    public function comment()
    {
        return $this->hasMany(StoryComment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeCustomFilter($query, $filters)
    {
        
        if ($month = @$filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if ($year = @$filters['year']) {
            $query->whereYear('created_at', $year);
        }

        if ($category = @$filters['category_id']) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }
    }
}
