<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Events\MQTTReceived;
use App\MQTT\ScannerExtractor;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class MQTTListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MQTT Listener';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $mqtt = MQTT::connection();
            foreach (Location::latest()->get() as $location) {
                $topic = "mayora/{$location->gln}";
                $mqtt->subscribe($topic, function (string $topic, string $message) use ($location) {
                    $data = (new ScannerExtractor($message))->extract()->toArray();
                    MQTTReceived::dispatch($location, $data, $message, $topic);
                    $this->info($location->name . ' Data Received.');
                }, 1);
            }
            // listen mqtt server
            $mqtt->loop(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
