<?php

namespace App\Http\Controllers;

use App\Models\Sync;
use GuzzleHttp\Client;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\InventoryReport;
use App\Http\Resources\SyncResource;

class SyncController extends Controller
{
    protected $trying = 0;

    public function index()
    {
        return view('sync.index');
    }

    public function log(Request $request)
    {
        $rpp = $request->input('per_page', 20);
        $rows = new Sync;
        if($request->has('sort') && $request->sort != '') {
            list($sort, $dir) = explode('|', $request->sort);
            $rows = $rows->orderBy($sort, $dir);
        }
        if($request->has('q') && $request->q != ''){
            $keyword = $request->input('q');
            $rows = $rows->where('date', 'LIKE', '%'. $keyword . '%');
        }
        $rows = $rows->latest()->paginate($rpp);

        return SyncResource::collection($rows);
    }

    public function sync(Request $request)
    {
        $this->validate($request, ['date' => 'required']);

        $date = $request->input('date');
        // $already = Sync::where('date', $date)->whereStatus(Sync::SUCCESS)->first();
       
        // if(! $already) {
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
        // }

        return response()->json(['success' => true]);
    }


    protected function send($data, $date)
    {
        try {
            $this->trying++;
            $client = new Client;
            $resp = $client->request('POST', config('warehouse.sap_sync_url'), [
                'json' => $data
            ]);
            
            Sync::updateOrCreate([
                'date' => $date,
            ], [
                'location_id' => config('warehouse.location') ?: 1,
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
                    'location_id' => config('warehouse.location') ?: 1,
                    'status' => Sync::FAILED,
                    'trying' => $this->trying,
                    'response' => (string) $resp
                ]);
            }
        }
    }
}
