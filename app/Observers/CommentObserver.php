<?php

namespace App\Observers;

use App\Models\Comment;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class CommentObserver
{
    public function saving(Comment $comment)
    {
        // XSS filtering
        $comment->content = clean($comment->content, 'comment');
    }

}