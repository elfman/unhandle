<?php

namespace App\Models;

use App\Models\Traits\ViewCountHelper;
use App\Models\Traits\VoteHelper;
use Spatie\Tags\HasTags;

class Question extends Model
{
    use HasTags;
    use VoteHelper;
    use ViewCountHelper;

    protected $fillable = ['title', 'brief', 'body', 'user_id', 'vote_count', 'answer_count', 'view_count', 'accept_answer', 'is'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function link($extra = null)
    {
        return route('questions.show', $this->id) . $extra;
    }

    public function relativeQuestions()
    {
        $sql = <<<SQL
SELECT * FROM questions WHERE id IN (        
SELECT DISTINCT taggable_id FROM taggables WHERE tag_id IN (        
SELECT `tag_id` FROM taggables WHERE `taggable_id`={$this->id}
)
) ORDER BY created_at DESC LIMIT 10
SQL;

        return $this->fromQuery($sql);
    }
}
