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
        // Schedule subscription update command daily at 11:59 PM
        $schedule->command('subscription:update')
                 ->dailyAt('23:59')
                 ->withoutOverlapping()
                 ->onSuccess(function () {
                     \Log::info('Subscription update ran successfully.');
                 })
                 ->onFailure(function () {
                     \Log::error('Subscription update failed.');
                 });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Load all commands in app/Console/Commands
        $this->load(__DIR__ . '/Commands');

        // Load commands defined in routes/console.php
        require base_path('routes/console.php');
    }
}