<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class Notifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $user;
    public string $notification;

    public function __construct(string $user, string $notification)
    {
        $this->user = $user;
        $this->notification = $notification;
    }
    // id for the user
    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->user);
    }

    public function broadcastAs()
    {
        return 'notificationCount';
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->user,
            'notification' => $this->notification,
        ];
    }
}
