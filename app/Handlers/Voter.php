<?php

namespace App\Handlers;

use App\Models\Question;

class Voter {
    public function questionUpVote(Question $question)
    {
        if ($question->votes()->ByWhom(Auth::id())->WithType('upvote')->count()) {
            $question->votes()->ByWhom(Auth::id())->WithType('upvote')->delete();
        }
    }
}