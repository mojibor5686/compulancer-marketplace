<?php

namespace App\Models;


use App\Traits\CustomStatus;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Software extends Model
{
    use  GlobalStatus, CustomStatus;

    protected $casts = [
        'tag'          => 'array',
        'features'     => 'array',
        'extra_image'  => 'array',
        'file_include' => 'array',
    ];

    public function scopeSorting($query)
    {

        if (request()->sorting) {
            if (request()->sorting == 'high') {
                $query->orderBy('price', "DESC");
            } elseif (request()->sorting == "low") {
                $query->orderBy('price', "ASC");
            }
        } else {
            $query->orderBy('id', "DESC");
        }
    }

    public function stepBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->step >= 4) {
                $html = '<span class="badge badge--success">' . trans('Completed') . '</span>';
            } else {
                $html = '<span class="badge badge--warning" data-bs-toggle="tooltip" data-bs-placement="top" title="' . trans('Current Step: ') . $this->step . '">' . $this->step . '</span>';
            }
            return $html;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
