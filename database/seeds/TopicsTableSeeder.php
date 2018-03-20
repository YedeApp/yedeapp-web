<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = factory(Topic::class)->times(200)->make()->toArray();
        
        Topic::insert($topics);
    }
}
