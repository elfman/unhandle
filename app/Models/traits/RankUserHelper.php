<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait RankUserHelper
{
    static protected $rank_cache_key = 'unhandle_user_reputation_rank';
    static protected $rank_total_cache_key = 'unhandle_user_total_reputation_rank';
    static protected $rank_expire_in_minutes = 65;

    static public function getUserLastWeekReputationRank()
    {
        return Cache::remember(self::$rank_cache_key, self::$rank_expire_in_minutes, function () {
            return self::calculateLastWeekReputationRank();
        });
    }
    static public function calculateAndCacheLastWeekReputationRank()
    {
        $rank = self::calculateLastWeekReputationRank();
        self::cacheLastWeekReputationRank($rank);
        return $rank;
    }

    static private function calculateLastWeekReputationRank()
    {
        $beforeDate = Carbon::parse('-1 week')->toDateTimeString();
        $sql = <<<EDT
SELECT *, (question_score+answer_score) as last_week_reputation FROM users
 LEFT JOIN
(SELECT user_id, SUM(CASE WHEN `is_accepted`=true THEN vote_scores2.score+15 ELSE vote_scores2.score END) as answer_score FROM (answers LEFT JOIN
(SELECT votable_id, SUM(CASE WHEN `status`="upvote" THEN 10 WHEN `status`="downvote" THEN -3 ELSE NULL END) as score FROM votes WHERE `votable_type`='App\\\\Models\\\\Answer' AND created_at > '{$beforeDate}' GROUP BY votable_id) as vote_scores2
ON answers.id=vote_scores2.`votable_id`) GROUP BY user_id) as answer_scores
ON answer_scores.user_id=users.id
LEFT JOIN
(SELECT user_id, SUM(vote_scores1.`score`) as question_score FROM (questions LEFT JOIN
(SELECT votable_id, SUM(CASE WHEN `status`='upvote' THEN 10 WHEN `status`='downvote' THEN -3 ELSE NULL END) as score FROM votes WHERE `votable_type`='App\\\\Models\\\\Question' AND created_at > '{$beforeDate}' GROUP BY votable_id) as vote_scores1
ON questions.id=vote_scores1.`votable_id`) GROUP BY user_id) as question_scores
ON question_scores.user_id=users.id
ORDER BY (question_score+answer_score) DESC LIMIT 10
EDT;
        $rank = DB::select($sql);
        return $rank;
    }

    static private function cacheLastWeekReputationRank($rank)
    {
        Cache::put(self::$rank_cache_key, $rank, self::$rank_expire_in_minutes);
    }

    static public function getUserTotalReputationRank()
    {
        return Cache::remember(self::$rank_total_cache_key, self::$rank_expire_in_minutes, function () {
            return self::calculateTotalReputationRank();
        });
    }

    static public function calculateAndCacheTotalReputationRank()
    {
        $rank = self::calculateTotalReputationRank();
        self::cacheTotalReputationRank($rank);
        return $rank;
    }


    static public function calculateTotalReputationRank()
    {
        $sql = <<<EOT
SELECT id, name, `reputation`, avatar, email FROM users ORDER BY reputation DESC LIMIT 10
EOT;
        $rank = DB::select($sql);
        return $rank;
    }

    static private function cacheTotalReputationRank($rank)
    {
        Cache::put(self::$rank_total_cache_key, $rank, self::$rank_expire_in_minutes);
    }

}