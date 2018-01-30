<?php

namespace App\Models;

class Question extends Model
{
    protected $fillable = ['title', 'brief', 'body', 'user_id', 'vote_count', 'answer_count', 'view_count', 'solved_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
