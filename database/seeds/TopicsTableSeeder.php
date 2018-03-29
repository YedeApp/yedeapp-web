<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Chapter;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = factory(Topic::class)
        ->times(200)
        ->make()
        ->each(function ($topic, $index) {
            $topic->course_id = Chapter::find($topic->chapter_id)->course_id;
        })
        ->toArray();

        Topic::insert($topics);
    }
}
