<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

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
     * Course index page containing simple intros.
     *
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return View
     */
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    /**
     * Course chapters page.
     *
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return View
     */
    public function chapters(Course $course)
    {
        $chapters = $course->chapters;
        return view('course.chapters', compact('course', 'chapters'));
    }
}
