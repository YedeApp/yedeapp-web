<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     *
     * @param  Illuminate\Foundation\Http\FormRequest\CommentRequest  $request
	 * @param  Illuminate\Database\Eloquent\Model\Comment  $comment
     * @return void
     */
	public function store(CommentRequest $request, Comment $comment)
	{
		$comment->fill($request->all());
		$comment->user_id = Auth::id();
        $comment->save();

		return redirect(jumpToComment($comment));
    }

    /**
     * Delete a comment.
     *
     * @param  Illuminate\Database\Eloquent\Model\Comment  $comment
     * @return redirect
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('destroy', $comment);

		$comment->delete();

        return redirect($comment->topic->link())->with('message', '删除成功');
    }
}