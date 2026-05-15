<?php

namespace App\Traits;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait CustomStatus
{

    public function scopeUserActiveCheck($query)
    {
        return $query->whereHas('user', function ($user) {
            $user->active();
        });
    }

    public function scopeNotAuthUser($query)
    {
        return $query->whereHas('user', function ($user) {
            $user->active()->where('id', '!=', auth()->id());
        });
    }

    public function scopeCheckData($query)
    {
        return $query->whereHas('category', function ($category) {
            $category->active();
        })->whereHas('subCategory', function ($subCategory) {
            $subCategory->active();
        });
    }

    public function scopeCheckCategory($query)
    {
        return $query->whereHas('category', function ($category) {
            $category->active();
        });
    }

    public function scopeCheckSubCategory($query)
    {
        return $query->whereHas('subCategory', function ($subCategory) {
            $subCategory->active();
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', Status::APPROVED);
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', Status::CANCELED);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', Status::CLOSED);
    }


    public function workingStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';

            if ($this->working_status == Status::WORKING_COMPLETED) {
                $html = '<span class="badge badge--success">' . trans("Completed") . '</span>';
            } elseif ($this->working_status == Status::WORKING_DELIVERED) {
                $html = '<span class="badge badge--primary">' . trans("Delivered") . '</span>';
            } elseif ($this->working_status == Status::WORKING_INPROGRESS) {
                $html = '<span class="badge badge--info">' . trans("Inprogress") . '</span>';
            } elseif ($this->working_status == Status::WORKING_EXPIRED) {
                $html = '<span class="badge badge--danger">' . trans("Expired") . '</span>';
            } elseif ($this->working_status == Status::WORKING_DISPUTED) {
                $html = '<span class="badge badge--danger">' . trans("Disputed") . '</span> <button class="btn btn-danger btn-rounded text-white badge disputeShow" data-bs-toggle="tooltip" data-bs-placement="top" title="' . trans("Dispute Reason") . '" data-dispute="' . $this->reason . '"><i class="fa fa-info mx-0"></i></button>';
            } else {
                $html = '<span class="badge badge--warning">' . trans("N/A") . '</span>';
                return $html;
            }



            if (request()->is('admin*')) {
                $html .= '<br>' . diffforhumans($this->updated_at);
            }

            return $html;
        });
    }
}
