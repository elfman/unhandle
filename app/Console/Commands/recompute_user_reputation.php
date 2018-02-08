<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class recompute_user_reputation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unhandle:recompute_user_reputation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '重新计算用户的声望';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('开始计算声望');

        $sql = <<<EDC
UPDATE users LEFT JOIN
(SELECT user_id, SUM(vote_scores1.`score`) as question_score FROM (questions LEFT JOIN
(SELECT votable_id, SUM(CASE WHEN `status`='upvote' THEN 10 WHEN `status`='downvote' THEN -3 ELSE NULL END) as score FROM votes WHERE `votable_type`='App\\\\Models\\\\Question' GROUP BY votable_id) as vote_scores1
ON questions.id=vote_scores1.`votable_id`) GROUP BY user_id) as question_scores
ON question_scores.user_id=users.id
LEFT JOIN
(SELECT user_id, SUM(CASE WHEN `is_accepted`=true THEN vote_scores.score+15 ELSE vote_scores.`score` END) as answer_score FROM (answers LEFT JOIN
(SELECT votable_id, SUM(CASE WHEN `status`='upvote' THEN 10 WHEN `status`='downvote' THEN -3 ELSE NULL END) as score FROM votes WHERE `votable_type`='App\\\\Models\\\\Answer' GROUP BY votable_id) as vote_scores
ON answers.id=vote_scores.`votable_id`) GROUP BY user_id) as answer_scores
ON answer_scores.user_id=users.id
SET users.reputation=coalesce(question_score, 0)+coalesce(answer_score, 0)
EDC;

        DB::update($sql);

        $this->info('计算完毕');
    }
}
