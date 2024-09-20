<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorDataRecived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sensorData;

    /**
     * Create a new event instance.
     *
     * @param mixed $sensorData
     * @return void
     */
    public function __construct($sensorData)
    {
        $this->sensorData = $sensorData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
       
            return ['sensor-data'];
        
    }

    /**
     * The data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastAs()
    {
        return 'event';
    }
}

