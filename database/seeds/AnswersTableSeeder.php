<?php

use Illuminate\Database\Seeder;
use App\Models\Answer;

class AnswersTableSeeder extends Seeder
{
    public function run()
    {
        $answers = factory(Answer::class)->times(3000)->make();

        Answer::insert($answers->toArray());

        DB::update('UPDATE questions, (SELECT `question_id`, COUNT(question_id) AS answer_count FROM answers GROUP BY `question_id`) AS c SET questions.answer_count=c.answer_count WHERE questions.id=c.question_id;');
    }

}

