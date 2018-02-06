<?php

namespace App\Events;

use App\Models\Answer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AcceptAnswer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $answer;
    public $type;

    public function __construct(Answer $answer, $type)
    {
        $this->answer = $answer;
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
