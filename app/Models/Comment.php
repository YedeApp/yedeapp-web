<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'user_id', 'topic_id', 'course_id', 'parent_id', 'likes', 'sorting'
    ];

    public function course()
    {
        $this->belongsTo(Course::class);
    }

    public function author()
    {
        $this->belongsTo(User::class);
    }

    public function topic()
    {
        $this->belongsTo(Topic::class);
    }
}