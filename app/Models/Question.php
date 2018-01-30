<?php

namespace App\Models;

class Question extends Model
{
    protected $fillable = ['title', 'body', 'vote_count', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
