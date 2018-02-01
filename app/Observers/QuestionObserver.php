<?php

namespace App\Observers;

use App\Models\Question;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class QuestionObserver
{
    public function creating(Question $question)
    {
        $question->brief = getTextBrief($question->body);
        $body = clean($question->body, 'question_body');

        $question->body = preg_replace('/^(\&gt; )/m', '> ', $body);

    }

    public function updating(Question $question)
    {
        $question->brief = getTextBrief($question->body);
        $question->body = clean($question->body, 'question_body');
    }
}