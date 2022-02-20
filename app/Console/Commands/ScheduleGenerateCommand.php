<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Console\Command;

class ScheduleGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:schedule:generator {--from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate schedule weekly';

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
        $from = $this->option('from');
        
        $fromDate = Carbon::now();
        if(! $from) {
            $fromDate = Carbon::parse($from);
        }

        $start = $fromDate->startOfWeek()->format('Y-m-d H:i:s');
        $end = $fromDate->endOfWeek()->format('Y-m-d H:i:s');
        
        for($i=0; $i <= Carbon::parse($start)->diffInDays(Carbon::parse($end)); $i++) {
            $date = Carbon::parse($start)->addDays($i);
            foreach(Shift::all() as $shift) {
                $d = $date->format('Y-m-d');
                if(in_array($date->format('w'), $shift->day)) {
                    $schedule = Schedule::where('shift_id', $shift->id)->whereDate('from', $d)->latest()->first();
                    $from = Carbon::parse($d . ' ' . $shift->from);
                    $to = Carbon::parse($d . ' ' . $shift->to);

                    if($shift->from > $shift->to) {
                        $to = $to->addDay();
                    }

                    if(! $schedule) {
                        Schedule::create([
                            'shift_id' => $shift->id,
                            'from' => $from,
                            'to' => $to,
                        ]);
                    }else{
                        $schedule->update([
                            'from' => $from,
                            'to' => $to
                        ]);
                    }
                }
            }
        }

        return 0;
    }
}
