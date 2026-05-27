<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePackage extends Model {
    /**
    * টেবিলের নাম ( যদি মাইগ্রেশনে 'service_packages' রাখা হয়ে থাকে,
    * তাহলে লারাভেল অটোমেটিক চিনে নেয়। তাও সুরক্ষার জন্য উল্লেখ করা ভালো )।
    */
    protected $table = 'service_packages';

    /**
    * যে কলামগুলো Mass Assignment ( একসাথে সেভ বা আপডেট ) করার অনুমতি দেওয়া হলো।
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'service_id',
        'package_type',
        'package_title',
        'package_description',
        'price',
        'delivery_time',
        'features',
    ];

    /**
    * ডেটাবেজের নির্দিষ্ট কলামের ডাটা টাইপ কনভার্ট ( Casting ) করার নিয়ম।
    * এখানে 'features' কলামটি ডাটাবেজে JSON হিসেবে থাকবে কিন্তু কোডে এটি Array হিসেবে কাজ করবে।
    *
    * @var array<string, string>
    */
    protected $casts = [
        'features' => 'array',
        'price'    => 'decimal:2', // প্রাইসকে সবসময় ২ দশমিকের ডেসিমেল ফরম্যাটে রাখবে
    ];

    /**
    * রিলেশনশিপ: একটি প্যাকেজ অবশ্যই একটি নির্দিষ্ট সার্ভিসের অধীনে থাকবে।
    * ( Inverse of One-to-Many )
    *
    * @return BelongsTo
    */

    public function service(): BelongsTo {
        return $this->belongsTo( Service::class, 'service_id' );
    }
}