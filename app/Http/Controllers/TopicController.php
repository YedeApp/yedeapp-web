<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Course;
use Auth;

class TopicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    /**
     * Topic show page.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @param  Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return Illuminate\Contracts\View\View
     */
    public function show(Request $request, Course $course, Topic $topic)
    {
        // Get previous and next topic
        $prev = Topic::where('id', '<', $topic->id)->where('course_id', $topic->course_id)->where('chapter_id', $topic->chapter_id)->orderBy('id', 'desc')->first();
        $next = Topic::where('id', '>', $topic->id)->where('course_id', $topic->course_id)->where('chapter_id', $topic->chapter_id)->orderBy('id', 'asc')->first();

        // Get comments and replies.
		$comments = $topic->comments()->where('parent_id', null)->orderBy('likes', 'desc')->orderBy('created_at', 'desc')->get()->load('user');
        $replies = $topic->comments()->where('parent_id', '>', 0)->orderBy('created_at', 'asc')->get();

        // Only Admin can delete and reply comments
        if ( 1 ) {
            $can['delete-comment'] = true;
            $can['reply-comment'] = true;
        } else {
            $can['delete-comment'] = false;
            $can['reply-comment'] = false;
        }

        return view('topic.show', compact('course', 'topic', 'comments', 'replies', 'prev', 'next', 'can'));
    }

    /**
     * Delete a topic.
     *
     * @param  Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return redirect
     */
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

		$topic->delete();

        return redirect()->route('course.chapters', $topic->course)->with('message', '删除成功');

    }

}