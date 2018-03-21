<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

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
     * Check if user has subscribed to the course.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return boolean
     */
    public function show(User $user, Course $course)
    {
        return $user->isSubscriberOf($course);
    }
}
