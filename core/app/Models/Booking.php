<?php

namespace App\Models;

use App\Constants\Status;

use App\Traits\CustomStatus;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
{
    use GlobalStatus, CustomStatus;

    protected $guarded = ['id'];

    protected $casts = [
        'extra_service' => 'array'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function software()
    {
        return $this->belongsTo(Software::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function disputer()
    {
        return $this->belongsTo(User::class, 'disputer_id');
    }

    public function workFiles()
    {
        return $this->hasMany(WorkFile::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    // Scope
    public function scopeCheckService($query, $orderNumber)
    {
        return $query->where('order_number', $orderNumber)->where('service_id', '!=', 0);
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::BOOKING_PENDING);
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', Status::BOOKING_CANCELED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('working_status', Status::WORKING_COMPLETED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('working_status', Status::WORKING_DELIVERED);
    }

    public function scopeInprogress($query)
    {
        return $query->where('working_status', Status::WORKING_INPROGRESS);
    }

    public function scopeDisputed($query)
    {
        return $query->where('working_status', Status::WORKING_DISPUTED);
    }

    public function scopeRefunded($query)
    {
        return $query->where('working_status', Status::BOOKING_REFUNDED);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', Status::BOOKING_EXPIRED);
    }

    public function scopeIncomplete($query)
    {
        return $query->where('bookings.service_id', '!=', 0)->where('bookings.status', Status::BOOKING_PENDING);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', Status::BOOKING_PAID);
    }

    public function bookingStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::BOOKING_PENDING) {
                $html = '<span class="badge badge--warning">' . trans("Pending") . '</span>';
            } elseif ($this->status == Status::BOOKING_CANCELED) {
                $html = '<span class="badge badge--warning">' . trans("Cancelled") . '</span> ';
            } elseif ($this->status == Status::BOOKING_APPROVED) {
                $html = '<span class="badge badge--success">' . trans("Approved") . '</span> ';
            } elseif ($this->status == Status::BOOKING_REFUNDED) {
                $html = '<span class="badge badge--danger">' . trans("Refunded") . '</span>';
            } elseif ($this->status == Status::BOOKING_EXPIRED) {
                $html = '<span class="badge badge--danger">' . trans("Expired") . '</span>';
            }

            return $html;
        });
    }
    public function paymentStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';

            if ($this->payment_status == Status::BOOKING_PAID) {
                $html = '<span class="badge badge--success">' . trans("Paid") . '</span>';
            } else {
                $html = '<span class="badge badge--danger">' . trans("Unpaid") . '</span>';
            }

            return $html;
        });
    }
}
