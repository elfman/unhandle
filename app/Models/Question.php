<?php

namespace App\Models;

use App\Models\Traits\VoteHelper;
use Spatie\Tags\HasTags;

class Question extends Model
{
    use HasTags;
    use VoteHelper;

    protected $fillable = ['title', 'brief', 'body', 'user_id', 'vote_count', 'answer_count', 'view_count', 'solved_by', 'is'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

}
