<?php

namespace App\Models;

class Chapter extends Model
{
    protected $fillable = [
        'name', 'user_id', 'course_id', 'sorting'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

}