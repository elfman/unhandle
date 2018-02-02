<?php

use Illuminate\Database\Seeder;
use App\Models\Answer;

class AnswersTableSeeder extends Seeder
{
    public function run()
    {
        $answers = factory(Answer::class)->times(300)->make();

        Answer::insert($answers->toArray());
    }

}

