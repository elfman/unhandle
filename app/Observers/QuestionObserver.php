<?php

namespace App\Observers;

use App\Models\Question;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class QuestionObserver
{
    public function creating(Question $question)
    {
        //
    }

    public function updating(Question $question)
    {
        //
    }
}