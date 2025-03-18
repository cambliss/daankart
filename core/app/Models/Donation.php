<?php

namespace App\Models;


use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
    public function deposit()
    {
        return $this->hasOne(Deposit::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', Status::DONATION_PAID);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', Status::DONATION_UNPAID);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::DONATION_PAID) {
                $html = '<span class="badge badge--success">' . trans("PAID") . '</span>';
            } elseif ($this->status == Status::DONATION_UNPAID) {
                $html = '<span class="badge badge--warning">' . trans("UNPAID") . '</span>';
            }
            return $html;
        });
    }

}
