<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * The course's intro page.
     *
     * @param  App\Models\Course  $course
     * @return View
     */
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }
}
