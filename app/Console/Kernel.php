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
        Commands\DrawWinnersCommand::class,
        ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     * Trong ví dụ trên, 1 là ngày trong tuần (0 là Chủ Nhật, 1 là Thứ Hai, v.v.) và '1:00' là thời gian chạy.
     *
     *
     * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('draw:winners')->weeklyOn(1, '1:00');

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
