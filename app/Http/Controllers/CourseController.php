<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Auth;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'chapters']]);
    }

    /**
     * Course introduction page.
     *
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return Illuminate\Contracts\View\View
     */
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    /**
     * Course chapters page.
     *
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return Illuminate\Contracts\View\View
     */
    public function chapters(Course $course)
    {
        $chapters = $course->chapters->load('topics');

        // Check if user has subscribed to the course.
        $canshow = optional(Auth::user())->can('show', $course);

        return view('course.chapters', compact('course', 'chapters', 'canshow'));
    }
}
