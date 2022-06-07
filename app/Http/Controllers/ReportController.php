<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Models\InventoryReport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\InventoryReportResource;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->has('date')? $request->date : date('d-m-Y');
        $date = Carbon::parse($date)->format('Y-m-d');

        return view('report.index', compact('date'));
    }

    // get schedule id
    public function data(Request $request)
    {
        $date = $request->has('date')? $request->date : date('d-m-Y');
        $date = Carbon::parse($date);
        $rpp = $request->input('per_page', 15);

        $scheduleId = Schedule::whereDate('from', $date->format('Y-m-d'))->pluck('id')->toArray();
        $rows = InventoryReport::with('schedule.shift', 'product')->whereIn('schedule_id', $scheduleId)->paginate($rpp);

        return InventoryReportResource::collection($rows);
    }

    public function download(Request $request)
    {
        $date = $request->has('date')? $request->date : date('d-m-Y');
        $date = Carbon::parse($date)->format('Y-m-d');

        return Excel::download(new ReportExport($date), "rekap-{$date}.xlsx");
    }

    public function print(Request $request)
    {
        $date = $request->has('date')? $request->date : date('d-m-Y');
        $date = Carbon::parse($date)->format('Y-m-d');

        $scheduleId = Schedule::whereDate('from', $date)->pluck('id')->toArray();
        $rows = InventoryReport::with('schedule.shift', 'product')->whereIn('schedule_id', $scheduleId)->get();

        $data = $rows->map(function($row) {
            return [
                'date' => $row->created_at->format('d-m-Y'),
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
