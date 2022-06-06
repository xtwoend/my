<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\ScheduleResource;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        return view('schedule.index');
    }

    public function data(Request $request)
    {
        $rpp = $request->input('per_page', 20);
        $rows = Schedule::with('shift');
        if($request->has('sort') && $request->sort != '') {
            list($sort, $dir) = explode('|', $request->sort);
            $rows = $rows->orderBy($sort, $dir);
        }
        if($request->has('q') && $request->q != ''){
            $keyword = $request->input('q');
            $rows = $rows->where('from', 'LIKE', '%'. $keyword . '%');
        }
        $rows = $rows->orderBy('from', 'desc')->paginate($rpp);
        return ScheduleResource::collection($rows);
    }

    public function active()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $active = Schedule::with('shift')->where('from', '<=', $now)->where('to', '>=', $now)->first();
        if(! $active) {
            $exitCode = Artisan::call('attendance:schedule:generator', [
                '--from' => $now
            ]);
            $active = Schedule::where('from', '<=', $now)->where('to', '>=', $now)->first();
        }
       
        return $active;
    }

    public function dropdown()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $schedules = Schedule::with('shift')->where('from', '<=', $now)->orderBy('from', 'desc')->limit(5)->get();
        
        return ScheduleResource::collection($schedules);
    }
}
