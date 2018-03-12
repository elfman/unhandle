<?php

namespace App\Observers;

use App\Models\Answer;
use App\Notifications\AnswerCreated;

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
        $question = $answer->question;
        $question->increment('answer_count');
        if ($answer->user_id !== $question->user_id) {
            $question->user->notify(new AnswerCreated($answer));
        }
    }

    public function updating(Answer $answer)
    {
//        $answer->body = cleanMarkdown($answer->body);
    }

    public function deleted(Answer $answer)
    {
        $question = $answer->question;
        $question->answer_count--;
        if ($answer->is_accepted) {
            $question->accept_answer = null;
        }
        $question->save();
    }
}