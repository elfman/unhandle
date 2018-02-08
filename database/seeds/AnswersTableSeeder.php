<?php

use App\Models\Question;
use Illuminate\Database\Seeder;
use App\Models\Answer;

class AnswersTableSeeder extends Seeder
{
    public function run()
    {
        $answers = factory(Answer::class)->times(3000)->make();

        Answer::insert($answers->toArray());

        DB::update('UPDATE questions, (SELECT `question_id`, COUNT(question_id) AS answer_count FROM answers GROUP BY `question_id`) AS c SET questions.answer_count=c.answer_count WHERE questions.id=c.question_id;');

        $questions = Question::all();
        $faker = app(Faker\Generator::class);
        foreach ($questions as $question) {
            if ($faker->boolean(10) || $question->answers->count() === 0) continue;

            $answer = $question->answers->random();
            $answer->is_accepted = true;
            $answer->save();
            $question->accept_answer = $answer->id;
            $question->save();
        }
    }

}

