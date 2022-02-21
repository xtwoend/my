<?php

namespace App\Console;

use Carbon\Carbon;
use App\Console\Commands\SyncCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $fastDay = Carbon::now()->subDay()->format('Y-m-d');
        $schedule->command('attendance:schedule:generator')->weeklyOn(1, '00:00');
        $schedule->command(SyncCommand::class, [$fastDay])->dailyAt('07:22');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
