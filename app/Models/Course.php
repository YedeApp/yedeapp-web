<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'cover', 'banner', 'intro', 'introduction', 'price', 'sorting'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
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