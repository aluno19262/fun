<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('quotas:check_quota_payed')->yearlyOn(12,24);
        $schedule->command('quotas:check_quota_payed')->yearlyOn(12,28);
        $schedule->command('quotas:check_quota_payed')->yearlyOn(12,31);
        $schedule->command('quotas:check_quota_payed')->yearlyOn(1,7);
        $schedule->command('quotas:check_second_semester_payed')->yearlyOn(6,23);
        $schedule->command('quotas:check_second_semester_payed')->yearlyOn(6,27);
        $schedule->command('quotas:check_second_semester_payed')->yearlyOn(6,30);
        $schedule->command('quotas:check_second_semester_payed')->yearlyOn(7,7);
        $schedule->command('queue:restart')->hourly();
        // run the queue worker "without overlapping"
        // this will only start a new worker if the previous one has died
        $schedule->command("queue:work --tries=3")
            ->everyMinute()
            ->name('queue_notifications')
            ->withoutOverlapping();
        //$schedule->command('generate:yearly_quotas')->yearlyOn(6,24);
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
