<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Models\InventoryReport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\InventoryReportResource;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->has('from')? $request->from : date('d-m-Y');
        $from = Carbon::parse($from)->format('Y-m-d');

        $to = $request->has('to')? $request->to : date('d-m-Y');
        $to = Carbon::parse($to)->format('Y-m-d');

        return view('report.index', compact('from', 'to'));
    }

    // get schedule id
    public function data(Request $request)
    {
        $from = $request->has('from')? $request->from : date('d-m-Y');
        $from = Carbon::parse($from);
        $to = $request->has('to')? $request->to : date('d-m-Y');
        $to = Carbon::parse($to);

        $rpp = $request->input('per_page', 15);

        $scheduleId = Schedule::whereBetween(DB::raw('DATE(`from`)'), [$from->format('Y-m-d'), $to->format('Y-m-d')])->pluck('id')->toArray();
        
        $rows = InventoryReport::with('schedule.shift', 'product')->whereIn('schedule_id', $scheduleId);

        if($request->has('sort') && ! is_null($request->sort)) {
            $sort = $request->sort;
            list($field, $dir) = explode('|', $sort);

            switch ($field) {
                case 'schedule.from':
                    
                    break;
                case 'schedule.shift.name':
                    # code...
                    break;
                case 'product.gtin':
                    $rows = $rows->with(['product' => function($query) use ($dir) {
                        return $query->orderBy('gtin', $dir);
                    }]);
                    break;
                default:
                    # code...
                    break;
            }
        }

        $rows = $rows->paginate($rpp);

        return InventoryReportResource::collection($rows);
    }

    public function download(Request $request)
    {
        $from = $request->has('from')? $request->from : date('d-m-Y');
        $from = Carbon::parse($from);
        $to = $request->has('to')? $request->to : date('d-m-Y');
        $to = Carbon::parse($to);

        return Excel::download(new ReportExport($from, $to), "rekap-{$from}.xlsx");
    }

    public function print(Request $request)
    {
        $from = $request->has('from')? $request->from : date('d-m-Y');
        $from = Carbon::parse($from);
        $to = $request->has('to')? $request->to : date('d-m-Y');
        $to = Carbon::parse($to);

        $scheduleId = Schedule::whereBetween(DB::raw('DATE(`from`)'), [$from->format('Y-m-d'), $to->format('Y-m-d')])->pluck('id')->toArray();
        $rows = InventoryReport::with('schedule.shift', 'product')->whereIn('schedule_id', $scheduleId)->get();

        $data = $rows->map(function($row) {
            return [
                'date' => $row->schedule->from->format('d-m-Y'),
                'shift' => $row->schedule->shift->name,
                'line' => $row->product->line,
                'gtin' =>$row->product->gtin,
                'name' => $row->product->name,
                'varian_pack' => $row->product->varian_pack,
                'qty' => $row->qty,
                'pallet_qty' => $row->pallet_qty,
                'total' => $row->total,
                'return_qty' => $row->return_qty
            ];
        });
        
        return response()->json($data);
    }
}
