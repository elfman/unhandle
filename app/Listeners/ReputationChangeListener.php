<?php

namespace App\Listeners;

use App\Events\AcceptAnswer;
use App\Events\UserVote;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReputationChangeListener
{
    const SCORE_UPVOTE = 10;
    const SCORE_DOWNVOTE = -3;
    const SCORE_ACCEPT = 15;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event instanceof UserVote) {
            $this->handleVoteEvent($event);
        } else if ($event instanceof AcceptAnswer) {
            $this->handleAcceptAnswerEvent($event);
        }
    }

    protected function handleVoteEvent($event)
    {
        $user = $event->vote->votable->user;
        $change = 0;
        switch ($event->type) {
            case 'upvote':
                $change = self::SCORE_UPVOTE;
                break;
            case 'downvote':
                $change = self::SCORE_DOWNVOTE;
                break;
            case 'unvote':
                if ($event->vote->status === 'upvote') {
                    $change = -self::SCORE_UPVOTE;
                } else {
                    $change = -self::SCORE_DOWNVOTE;
                }
                break;
            case 'upvoteFromDownvote':
                $change = -self::SCORE_DOWNVOTE + self::SCORE_UPVOTE;
                break;
            case 'downvoteFromUpvote':
                $change = -self::SCORE_UPVOTE + self::SCORE_DOWNVOTE;
                break;
            default:
                break;
        }
        $user->increment('reputation', $change);
        $user->save();
    }

    protected function handleAcceptAnswerEvent($event)
    {
        $user = $event->answer->user;
        if ($event->type === 'accept') {
            $user->increment('reputation', self::SCORE_ACCEPT);
        } else if ($event->type === 'cancel') {
            $user->decrement('reputation', -self::SCORE_ACCEPT);
        }
        $user->save();
    }

}
