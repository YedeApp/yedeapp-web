<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $userIds = App\Models\User::pluck('id')->toArray();
    $courseIds = App\Models\Course::pluck('id')->toArray();
    $topicIds = App\Models\Topic::pluck('id')->toArray();

    return [
        'content' => $faker->text,
        'user_id' => $faker->randomElement($userIds),
        'course_id' => $faker->randomElement($courseIds),
        'topic_id' => $faker->randomElement($topicIds),
        'likes' => $faker->randomDigitNotNull,
    ];
});