<?php

namespace App\Models;

use Spatie\Tags\HasTags;

class Question extends Model
{
    use HasTags;

    protected $fillable = ['title', 'brief', 'body', 'user_id', 'vote_count', 'answer_count', 'view_count', 'solved_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
