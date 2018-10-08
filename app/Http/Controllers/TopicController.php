<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @param  \Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Course $course, Topic $topic)
    {
        // Get previous and next topic
        $prev = Topic::where('id', '<', $topic->id)->where('course_id', $topic->course_id)->where('chapter_id', $topic->chapter_id)->orderBy('sorting', 'desc')->orderBy('id', 'desc')->first();
        $next = Topic::where('id', '>', $topic->id)->where('course_id', $topic->course_id)->where('chapter_id', $topic->chapter_id)->orderBy('sorting', 'asc')->orderBy('id', 'asc')->first();

        // Get comments and replies.
		$comments = $topic->comments()->where('parent_id', null)->orderBy('likes', 'desc')->orderBy('created_at', 'desc')->get()->load('user');
        $replies = $topic->comments()->where('parent_id', '>', 0)->orderBy('created_at', 'asc')->get();

        // Only Admin can delete and reply comments
        if ( optional(Auth::user())->isAdmin() ) {
            $can['delete-comment'] = true;
            $can['reply-comment'] = true;
        } else {
            $can['delete-comment'] = false;
            $can['reply-comment'] = false;
        }

        return view('topic.show', compact('course', 'topic', 'comments', 'replies', 'prev', 'next', 'can'));
    }

    /**
     * Topic create page.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return \Illuminate\View\View
     */
	public function create(Topic $topic)
	{
        $this->authorize('create', $topic);

		$courses = Course::where('user_id', Auth::id())->get();

		return view('topic.create_and_edit', compact('courses', 'topic'));
	}

    /**
     * Topic edit page.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return \Illuminate\View\View
     */
	public function edit(Topic $topic)
	{
		$this->authorize('update', $topic);

        $courses = Course::all()->load('chapters');

		return view('topic.create_and_edit', compact('courses', 'topic'));
    }

    /**
     * Store a new topic.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest\TopicRequest  $request
	 * @param  \Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return \Illuminate\Http\RedirectResponse
     */
	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
		$topic->user_id = Auth::id();
		$topic->save();

		return redirect($topic->link())->with('message', '新建成功');
	}

    /**
     * Update a topic.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest\TopicRequest  $request
	 * @param  \Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return \Illuminate\Http\RedirectResponse
     */
	public function update(TopicRequest $request, Topic $topic)
	{
        $this->authorize('update', $topic);

		$topic->update($request->all());

		return redirect($topic->link())->with('message', '更新成功');
	}

    /**
     * Delete a topic.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

		$topic->delete();

        return redirect()->route('course.chapters', $topic->course)->with('message', '删除成功');

    }

}