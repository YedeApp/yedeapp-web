<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
     * Check if can the user delete the comment.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Illuminate\Database\Eloquent\Model\Comment  $comment
     * @return boolean
     */
    public function destroy(User $user, Comment $comment)
    {
        // User can't destroy his/her own comments.
        return false;
    }
}
