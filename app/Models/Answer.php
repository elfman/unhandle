<?php

namespace App\Models;

use App\Models\Traits\VoteHelper;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;
    use VoteHelper;

    protected $fillable = ['user_id', 'question_id', 'vote_count', 'body', 'accepted', 'is'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}
