<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    static $number = 1;
    static $user_ids;
    static $answer_ids;
    static $question_ids;

    $user_ids = $user_ids ?: User::all()->pluck('id')->toArray();
    $answer_ids = $answer_ids ?: Answer::all()->pluck('id')->toArray();
    $question_ids = $question_ids ?: Question::all()->pluck('id')->toArray();

    $type = $faker->boolean(90) ? Answer::class : Question::class;
    $id = $faker->randomElement($type ? $answer_ids : $question_ids);

    return [
        // 'name' => $faker->name,
    ];
});
