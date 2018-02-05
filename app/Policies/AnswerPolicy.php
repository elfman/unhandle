<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

class AnswerPolicy extends Policy
{
    public function update(User $user, Answer $answer)
    {
        return $answer->user_id === $user->id;
    }

    public function destroy(User $user, Answer $answer)
    {
        return $answer->user_id === $user->id;
    }

    public function vote(User $user, Answer $answer)
    {
        return $answer->user_id !== $user->id;
    }

    public function comment(User $user, Answer $answer)
    {
        return true;
    }

    public function accept(User $user, Answer $answer)
    {
        return $user->id === $answer->question->user_id;
    }
}
