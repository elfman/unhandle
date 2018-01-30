<?php

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        $questions = factory(Question::class)->times(50)->make()->each(function ($question, $index) {
            if ($index == 0) {
                // $question->field = 'value';
            }
        });

        Question::insert($questions->toArray());
    }

}

