<?php

namespace App\Models;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'cover', 'banner', 'intro', 'introduction', 'price', 'sorting', 'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->ordered();
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPriceForHumans()
    {
        return ($this->price / 100);
    }

}