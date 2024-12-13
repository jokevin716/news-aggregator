<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Register your scheduled commands here
        $schedule->command('fetch:articles')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Load custom commands from the Commands directory
        $this->load(__DIR__.'/Commands');

        // Load additional console routes if any
        require base_path('routes/console.php');
    }
}
