<?php

namespace App\Events;

use App\Models\Vote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserVote
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vote;
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Vote $vote, $type)
    {
        $this->vote = $vote;
        $this->type = $type;
    }

//    /**
//     * Get the channels the event should broadcast on.
//     *
//     * @return \Illuminate\Broadcasting\Channel|array
//     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('channel-name');
//    }
}
