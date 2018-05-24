<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy extends ModelPolicy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Check if can user update the course.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return boolean
     */
    public function update(User $user, Course $course)
    {
        return $user->isAuthorOf($course);
    }
}
