<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id', 'chapter_id', 'course_id', 'comment_count', 'view_count', 'is_free', 'slug', 'description', 'sorting', 'active'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function link($courseSlug = '')
    {
        // Provide a course slug to avoidi query db multi-times.
        if (!$courseSlug) {
            $courseSlug = $this->course->slug;
        }

        // Inject parameters according to the order of the topic.show route
        return route('topic.show', [$courseSlug, $this->id, $this->slug]);
    }

    /**
     * Scope a query to only include active courses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
