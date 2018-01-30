<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

class QuestionPolicy extends Policy
{
    public function update(User $user, Question $question)
    {
        // return $question->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Question $question)
    {
        return true;
    }
}
