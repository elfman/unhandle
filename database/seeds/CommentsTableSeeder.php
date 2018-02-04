<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $id = 1;

        $faker = app(\Faker\Generator::class);

        $user_ids = User::all()->pluck('id')->toArray();
        $answers = Answer::all();
        $questions = Question::all();

        $comments = [];

        foreach ($questions as $answer) {
            if ($faker->boolean(20)) continue;

            $count = rand(1, 10);

            $time = $faker->dateTimeInInterval($answer->created_at, '+4 hours');

            for ($i = 0; $i < $count; $i++) {
                $comment = [
                    'user_id' => $faker->randomElement($user_ids),
                    'commentable_id' => $answer->id,
                    'commentable_type' => Question::class,
                    'body' => $faker->sentence,
                    'created_at' => $time,
                    'updated_at' => $time,
                    'reply_to' => null,
                ];
                if ($i > 0 && $faker->boolean) {
                    $comment['reply_to'] = rand($id - $i, $id);
                }
                array_push($comments, $comment);

                $id++;
                $time = $faker->dateTimeInInterval($time, '+2 hours');
            }
        }

        foreach ($answers as $answer) {
            if ($faker->boolean(20)) continue;

            $count = rand(1, 10);

            $time = $faker->dateTimeInInterval($answer->created_at, '+4 hours');

            for ($i = 0; $i < $count; $i++) {
                $comment = [
                    'user_id' => $faker->randomElement($user_ids),
                    'commentable_id' => $answer->id,
                    'commentable_type' => Answer::class,
                    'body' => $faker->sentence,
                    'created_at' => $time,
                    'updated_at' => $time,
                    'reply_to' => null,
                ];
                if ($i > 0 && $faker->boolean) {
                    $comment['reply_to'] = rand($id - $i, $id);
                }
                array_push($comments, $comment);

                $id++;
                $time = $faker->dateTimeInInterval($time, '+2 hours');
            }
        }

        Comment::insert($comments);

    }

}

