<?php
// app/Listeners/HandleSensorData.php
namespace App\Listeners;

use App\Events\SensorDataReceived;
use App\Events\SensorDataRecived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleSensorDataReceived implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(SensorDataRecived $event)
    {
        dd('Handling SensorDataReceived event with data: ', ['data' => $event->sensorData]);
    }
}
