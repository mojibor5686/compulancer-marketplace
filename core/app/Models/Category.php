<?php

namespace App\Models;


use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use GlobalStatus;

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function softwares()
    {
        return $this->hasMany(Software::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
