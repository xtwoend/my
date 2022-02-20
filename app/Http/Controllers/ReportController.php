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
}
