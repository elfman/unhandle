<?php

namespace App\Models\Traits;

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
                return -1;
            } else if ($vote->status === 'downvote') {
                $this->votes()->ByWhom($user_id)->update(['status' => 'upvote']);
                $this->increment('vote_count', 2);
                return 2;
            }
        } else {
            Vote::create([
                'status' => 'upvote',
                'user_id' => $user_id,
                'votable_id' => $this->id,
                'votable_type' => __CLASS__,
            ]);
            $this->increment('vote_count');
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
                return 1;
            } else if ($vote->status === 'upvote') {
                $this->votes()->ByWhom($user_id)->update(['status' => 'downvote']);
                $this->decrement('vote_count', 2);
                return -2;
            }
        } else {
            Vote::create([
                'status' => 'downvote',
                'user_id' => $user_id,
                'votable_id' => $this->id,
                'votable_type' => __CLASS__,
            ]);
            $this->decrement('vote_count');
            return -1;
        }
//        if ($this->votes()->ByWhom($user_id)->WithType('downvote')->count()) {
//            $this->votes()->ByWhom($user_id)->WithType('downvote')->delete();
//            $this->increment('vote_count');
//            return 1;
//        } else if ($this->votes()->ByWhom($user_id)->WithType('upvote')->count()){
//            $this->votes()->ByWhom($user_id)->WithType('upvote')->update(['is' => 'downvote']);
//            $this->decrement('vote_count', 2);
//            return -2;
//        } else {
//            Vote::create([
//                'user_id' => $user_id,
//                'votable_id' => $this->id,
//                'votable_type' => __CLASS__,
//                'is' => 'downvote',
//            ]);
//            $this->decrement('vote_count');
//            return -1;
//        }
    }

    public function voted()
    {
        $vote = $this->votes()->ByWhom(Auth::id())->limit(1)->get();
        Log::info($vote);
        if (count($vote) === 0) {
            return 'notVote';
        }
        return $vote[0]->is;
    }
}