<?php

namespace App\Models;

class Payment extends Model
{
    const STATUS_FAILED     = 0;
    const STATUS_SUCCEED    = 1;
    const STATUS_PENDING    = 2;

    protected $fillable = ['user_id', 'course_id', 'qr_id', 'status'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
