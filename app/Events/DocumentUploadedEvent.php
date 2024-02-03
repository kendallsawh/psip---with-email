<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentUploadedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $document;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @param  Document  $document
     * @return void
     */
    public function __construct($user, $document)
    {
        $this->user = $user;
        $this->document = $document;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
