<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Sync;
use GuzzleHttp\Client;
use App\Models\Schedule;
use App\Models\InventoryReport;
use Illuminate\Console\Command;

class SyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:sync {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report to SAP';

    /**
     * 
     */
    protected $trying = 0;

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
        $date = $this->argument('date');
        
        $already = Sync::where('date', $date)->whereStatus(Sync::SUCCESS)->first();
       
        if(! $already) {
            $ids = Schedule::whereDate('from', $date)->pluck('id')->toArray();
            $rows = InventoryReport::with('schedule.shift', 'product')->whereIn('schedule_id', $ids)->get();
            $data = [];
            foreach($rows as $row) {
                $data[] = [
                    'date' => $row->created_at->format('d-m-Y'),
                    'shift' => $row->schedule->shift->name,
                    'line' => $row->product->line,
                    'barcode' => $row->product->gtin,
                    'sku' => $row->product->name,
                    'qty' => $row->qty
                ];
            }
            $this->send($data, $date);
        }

        return 0;
    }


    public function send($data, $date)
    {
        try {
            $this->trying += 1;
            $client = new Client;
            $resp = $client->request('POST', config('warehouse.sap_sync_url'), [
                'json' => $data
            ]);
            
            Sync::updateOrCreate([
                'date' => $date,
            ], [
                'location_id' => 1,
                'status' => ($resp->getStatusCode() == 200 || $resp->getStatusCode() == 201)? Sync::SUCCESS : Sync::FAILED,
                'trying' => $this->trying,
                'response' => (string) $resp->getBody()
            ]);

        } catch (\Throwable $th) {
            $resp = $th->getMessage();
            if($this->trying < 3) {
                $this->send($data, $date);
            }else {
                Sync::updateOrCreate([
                    'date' => $date,
                ], [
                    'location_id' => 1,
                    'status' => Sync::FAILED,
                    'trying' => $this->trying,
                    'response' => (string) $resp
                ]);
            }
        }
    }
}
