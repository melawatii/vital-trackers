<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Application console kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * Define scheduled commands.
     */
    protected function schedule(Schedule $schedule): void
    {
        //
    }

    /**
     * Register application commands.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}