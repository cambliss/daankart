<?php

namespace App\Models;


use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use GlobalStatus;

    protected $fillable = ['user_id', 'campaign_id', 'fullname', 'email', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->badgeData(),
        );
    }

    public function badgeData()
    {
        $html = '';
        if ($this->status == Status::PUBLISHED) {
            $html = '<span class="badge badge--success">' . trans("Publish") . '</span>';
        } elseif ($this->status == Status::PENDING) {
            $html = '<span class="badge badge--warning">' . trans("Pending") . '</span>';
        }
        return  $html;
    }
}
