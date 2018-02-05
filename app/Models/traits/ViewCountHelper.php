<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Redis;

trait ViewCountHelper
{
    protected $hash = 'unhandle_question_view_count';
    protected $field_prefix = 'question_';

    public function latestViewCount()
    {
        $field = $this->field_prefix . $this->id;

        $val = Redis::hGet($this->hash, $field);
        if (!$val) {
            $val = $this->view_count;
            Redis::hSet($this->hash, $field, $val);
        }
        return $val;
    }

    public function increaseViewCount()
    {
        $field = $this->field_prefix . $this->id;
        $val = Redis::hGet($this->hash, $field);
        if (!$val) {
            $val = $this->view_count;
        }
        Redis::hSet($this->hash, $field, $val + 1);
        return $val;
    }

    public function syncViewCount()
    {
        $data = Redis::hGetAll($this->hash);

        foreach ($data as $question_id => $view_count) {
            $question_id = str_replace($this->field_prefix, '', $question_id);

            if ($question = $this->find($question_id)) {
                $question->view_count = $view_count;
                echo "question ${question_id} count ${view_count}\n";
                $question->save();
            }
        }
    }
}