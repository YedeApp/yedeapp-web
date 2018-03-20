<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'name', 'user_id', 'course_id', 'sorting'
    ];

    public function course()
    {
        $this->belongsTo(Course::class);
    }

    public function author()
    {
        $this->belongsTo(User::class);
    }

    public function topics()
    {
        $this->hasMany(Topic::class);
    }

}