<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pallet;
use App\Models\Product;
use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\InventoryReport;

class RecapitulationController extends Controller
{
    public function index(Request $request)
    {
        return view('inventory.form');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'schedule_id' => 'required',
            'pallet_qty' => 'required|min:1'
        ]);

        $report = InventoryReport::where([
            'location_id' => env('APP_LOCATION_ID', 1),
            'product_id' => $request->product_id,
            'schedule_id' => $request->schedule_id,
        ])->latest()->first();

        if(! $report) {
            $report = new InventoryReport;
            $report->fill([
                'location_id' => env('APP_LOCATION_ID', 1),
                'product_id' => $request->product_id,
                'schedule_id' => $request->schedule_id,
                'qty' => 0
            ]);
            $report->save();
        }
        
        $data = [];
        for($i=1; $i <= $request->pallet_qty; $i++) {
            Pallet::updateOrCreate([
                'inventory_report_id' => $report->id,
                'number' => $i,
            ], [
                'barcode' => $this->generateBarcode($report->schedule, $report->product->gtin, $i),
                'qty' => $request->input('box_pallet') ?? $report->product->box_pallet,
                'production_date' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        return redirect()->route('recapitulation.pallet', [
            'report_id' => $report->id
        ]);
    }

    public function pallet(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|exists:inventory_reports,id',
        ]);

        $report = InventoryReport::find($request->report_id);

        $pallets = $report->pallets;

        return view('inventory.recap', compact('pallets', 'report'));
    }

    public function destroy($id)
    {
        return Pallet::find($id)->delete();
    }

    public function update($id, Request $request)
    {
        $pallet = Pallet::findOrFail($id);
        $pallet->qty = $request->qty;
        $pallet->save();

        return $pallet;
    }

    private function generateBarcode($shift, $sku, $palletNo): string
    {
        return $shift->from->format('ymd') .'-'. $sku . '-'. sprintf("%03s", $palletNo);
    }
}
