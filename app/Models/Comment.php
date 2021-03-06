<?php

namespace App\Models;

class Comment extends Model
{
    protected $fillable = [
        'content', 'user_id', 'topic_id', 'course_id', 'parent_id', 'likes', 'sorting'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}