<?php

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChaptersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chapters = factory(Chapter::class)->times(20)->make()->toArray();
        
        Chapter::insert($chapters);
    }
}
