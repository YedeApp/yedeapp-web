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
}