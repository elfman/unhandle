<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        $user_ids = User::all()->pluck('id')->toArray();
        $question_ids = Question::all()->pluck('id')->toArray();
        $answer_ids = Answer::all()->pluck('id')->toArray();

        $status = ['upvote', 'downvote'];

        foreach ($user_ids as $user_id) {
            $data = array_map(function ($question_id) use ($user_id, $faker, $status) {
                return [
                    'user_id' => $user_id,
                    'votable_id' => $question_id,
                    'votable_type' => Question::class,
                    'status' => $faker->randomElement($status),
                ];
            }, $faker->randomElements($question_ids, 200));

            Vote::insert($data);

            $data = array_map(function ($answer_id) use ($user_id, $faker, $status) {
                return [
                    'user_id' => $user_id,
                    'votable_id' => $answer_id,
                    'votable_type' => Answer::class,
                    'status' => $faker->randomElement($status),
                ];
            }, $faker->randomElements($answer_ids, 500));

            Vote::insert($data);
        }

        $sql_update_questions_vote = <<<EDT
UPDATE questions, (SELECT `votable_id`, 
SUM(
  CASE WHEN `status`='upvote' THEN 1
       WHEN `status`='downvote' THEN -1
       ELSE 0 END
) as vote_count FROM votes
 WHERE `votable_type`='App\\\\Models\\\\Question' GROUP BY `votable_id`) as result
 SET questions.vote_count=result.vote_count WHERE questions.id=result.votable_id
EDT;

        $sql_update_answers_vote = 'UPDATE answers, (SELECT `votable_id`, 
SUM(
  CASE WHEN `status`=\'upvote\' THEN 1
       WHEN `status`=\'downvote\' THEN -1
       ELSE 0 END
) as vote_count FROM votes
 WHERE `votable_type`=\'App\\\\Models\\\\Answer\' GROUP BY `votable_id`) as result
 SET answers.vote_count=result.vote_count WHERE answers.id=result.votable_id';


        DB::update($sql_update_questions_vote);

        DB::update($sql_update_answers_vote);

        Artisan::call('unhandle:recompute_user_reputation');
    }
}
