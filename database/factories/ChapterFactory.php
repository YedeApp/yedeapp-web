<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Chapter::class, function (Faker $faker) {
    $userIds = App\Models\User::pluck('id')->toArray();
    $courseIds = App\Models\Course::pluck('id')->toArray();

    return [
        'name' => $faker->text(20),
        'user_id' => $faker->randomElement($userIds),
        'course_id' => $faker->randomElement($courseIds),
    ];
});