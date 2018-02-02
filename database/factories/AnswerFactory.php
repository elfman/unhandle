<?php

use App\Models\Question;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Answer::class, function (Faker $faker) {
    static $user_ids;
    static $question_ids;

    $user_ids = $user_ids ?: User::all()->pluck('id')->toArray();
    $question_ids = $question_ids ?: Question::all()->pluck('id')->toArray();

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'user_id' => $faker->randomElement($user_ids),
        'question_id' => $faker->randomElement($question_ids),
        'body' => $faker->text(600),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
