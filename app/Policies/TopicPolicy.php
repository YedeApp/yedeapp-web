<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy extends ModelPolicy
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
     * Check if can user delete the topic.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return boolean
     */
    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * Check if can user update the topic.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return boolean
     */
    public function update(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }
}
