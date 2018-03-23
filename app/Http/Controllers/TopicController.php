<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

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
     * @param  Illuminate\Database\Eloquent\Model\Topic  $topic
     * @return Illuminate\Contracts\View\View
     */
    public function show(Topic $topic)
    {
        return view('topic.show', compact('topic'));
    }

}
