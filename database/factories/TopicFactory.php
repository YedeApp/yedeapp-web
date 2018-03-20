<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $userIds = App\Models\User::pluck('id')->toArray();
    $courseIds = App\Models\Course::pluck('id')->toArray();
    $chapterIds = App\Models\Chapter::pluck('id')->toArray();

    return [
        'title' => $faker->sentence,
        'content' => $faker->text,
        'user_id' => $faker->randomElement($userIds),
        'course_id' => $faker->randomElement($courseIds),
        'chapter_id' => $faker->randomElement($chapterIds),
        'view_count' => $faker->randomNumber(3),
        'description' => $faker->sentence,
    ];
});