<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Question::class, function (Faker $faker) {
    static $user_ids;

    $user_ids = $user_ids ?: User::all()->pluck('id')->toArray();

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    $body = $faker->text(500);
//    $brief = getTextBrief($body);

    return [
        'title' => $faker->sentence,
        'body' => $body,
//        'brief' => $brief,
        'user_id' => $faker->randomElement($user_ids),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
