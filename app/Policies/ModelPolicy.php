<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelPolicy
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

    /**
     * Check if user has subscribed to the course.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  string  $ability
     * @return boolean
     */
    public function before($user, $ability)
	{
	    if ($user->isSuperAdmin()) {
	    	return true;
        }
	}

}
