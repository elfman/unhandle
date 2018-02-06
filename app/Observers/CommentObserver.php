<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\CommentCreated;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class CommentObserver
{
    public function created(Comment $comment)
    {
        $comment->commentable->user->notify(new CommentCreated($comment));
    }

    public function updating(Comment $comment)
    {
        //
    }
}