<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class AssistantStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $assistant;

    public function __construct($assistant)
    {
        $this->assistant = $assistant;
    }

    public function broadcastOn()
    {
        return new Channel('assistant-status');
    }

    public function broadcastAs()
    {
        return 'assistant.status';
    }
}
