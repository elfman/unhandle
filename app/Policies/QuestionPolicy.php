<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

class QuestionPolicy extends Policy
{
    public function update(User $user, Question $question)
    {
        return $question->user_id == $user->id;
    }

    public function destroy(User $user, Question $question)
    {
        return $question->user_id == $user->id;
    }

    public function vote(User $user, Question $question)
    {
        return $question->user_id !== $user->id;
    }
}
