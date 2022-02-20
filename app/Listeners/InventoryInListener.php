<?php

namespace App\Listeners;

use App\Events\MQTTReceived;
use App\MQTT\ScannerExtractor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InventoryInListener
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
     * @param  \App\Events\MQTTReceived  $event
     * @return void
     */
    public function handle(MQTTReceived $event)
    {
        $data = (object) $event->data;
        $location = $event->location;
       
        $location->addInventory($data->barcode, $data->line);
    }


}
