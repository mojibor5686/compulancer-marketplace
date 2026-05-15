<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function software()
    {
        return $this->belongsTo(Software::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
