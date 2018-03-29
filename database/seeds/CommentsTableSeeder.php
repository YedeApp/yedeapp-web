<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Topic;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = factory(Comment::class)
        ->times(200)
        ->make()
        ->each(function($comment, $index) {
            $comment->course_id = Topic::find($comment->topic_id)->course_id;
        })
        ->toArray();

        Comment::insert($comments);
    }
}
