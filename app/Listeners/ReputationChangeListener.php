<?php

namespace App\Listeners;

use App\Events\UserVote;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReputationChangeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserVote  $event
     * @return void
     */
    public function handle(UserVote $event)
    {
        $user = $event->vote->votable->user;
        $change = 0;
        switch ($event->type) {
            case 'upvote':
                $change = 15;
                break;
            case 'downvote':
                $change = -5;
                break;
            case 'unvote':
                if ($event->vote->status === 'upvote') {
                    $change = -15;
                } else {
                    $change = 5;
                }
                break;
            case 'upvoteFromDownvote':
                $change = 20;
                break;
            case 'downvoteFromUpvote':
                $change = -20;
                break;
            default:
                break;
        }
        $user->increment('reputation', $change);
        $user->save();
    }
}
