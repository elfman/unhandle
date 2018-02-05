<?php

namespace App\Models\Traits;

use App\Events\UserVote;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait VoteHelper
{
    public function upvote()
    {
        $user_id = Auth::id();
        $vote = $this->votes()->ByWhom($user_id)->first();
        if ($vote) {
            if ($vote->status === 'upvote') {
                $this->votes()->ByWhom($user_id)->delete();
                $this->decrement('vote_count');
                event(new UserVote($vote, 'unvote'));
                return -1;
            } else if ($vote->status === 'downvote') {
                $this->votes()->ByWhom($user_id)->update(['status' => 'upvote']);
                $this->increment('vote_count', 2);
                event(new UserVote($vote, 'upvoteFromDownvote'));
                return 2;
            }
        } else {
            $vote = Vote::create([
                'status' => 'upvote',
                'user_id' => $user_id,
                'votable_id' => $this->id,
                'votable_type' => __CLASS__,
            ]);
            $this->increment('vote_count');
            event(new UserVote($vote, 'upvote'));
            return 1;
        }
    }

    public function downvote()
    {
        $user_id = Auth::id();
        $vote = $this->votes()->ByWhom($user_id)->first();
        if ($vote) {
            if ($vote->status === 'downvote') {
                $this->votes()->ByWhom($user_id)->delete();
                $this->increment('vote_count');
                event(new UserVote($vote, 'unvote'));
                return 1;
            } else if ($vote->status === 'upvote') {
                $this->votes()->ByWhom($user_id)->update(['status' => 'downvote']);
                $this->decrement('vote_count', 2);
                event(new UserVote($vote, 'downvoteFromUpvote'));
                return -2;
            }
        } else {
            $vote = Vote::create([
                'status' => 'downvote',
                'user_id' => $user_id,
                'votable_id' => $this->id,
                'votable_type' => __CLASS__,
            ]);
            $this->decrement('vote_count');
            event(new UserVote($vote, 'downvote'));
            return -1;
        }
    }

    public function voted()
    {
        $vote = $this->votes()->ByWhom(Auth::id())->first();
        if (!$vote) {
            return 'notVote';
        }
        return $vote->status;
    }
}