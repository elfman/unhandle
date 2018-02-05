<?php

namespace App\Observers;

use App\Models\Answer;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class AnswerObserver
{
    public function creating(Answer $answer)
    {
//        $answer->body = cleanMarkdown($answer->body);
    }

    public function created(Answer $answer)
    {
        $answer->question->increment('answer_count');
    }

    public function updating(Answer $answer)
    {
//        $answer->body = cleanMarkdown($answer->body);
    }

    public function deleted(Answer $answer)
    {
        $answer->question->decrement('answer_count');
    }
}