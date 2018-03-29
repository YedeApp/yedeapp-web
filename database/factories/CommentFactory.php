<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $userIds = App\Models\User::pluck('id')->toArray();
    $topicIds = App\Models\Topic::pluck('id')->toArray();
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'content' => $faker->text,
        'user_id' => $faker->randomElement($userIds),
        'topic_id' => $faker->randomElement($topicIds),
        'likes' => $faker->randomDigitNotNull,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});