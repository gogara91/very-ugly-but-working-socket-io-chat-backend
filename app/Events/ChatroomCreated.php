<?php

namespace App\Events;

use App\Chatroom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatroomCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatroom;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chatroom $chatroom)
    {
        $this->chatroom = $chatroom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chatroom-created-' . $this->chatroom->id);
    }

    public function broadcastAs() {
        return 'chatroom-created';
    }
}
