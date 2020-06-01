<?php

namespace App\Console;

use App\Jobs\CalendarEvent\SchedulingEventJob;
use App\Jobs\Letter\SchedulingLetterJob;
use App\Jobs\Message\SchedulingMessageJob;
use App\Jobs\RequireFeedback\CleanUpFeedbackJob;
use App\Jobs\RequireFeedback\SchedulingRequireFeedbackJob;
use App\Jobs\Seminar\SchedulingSeminarJob;
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
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new SchedulingLetterJob())->everyFiveMinutes();
        $schedule->job(new SchedulingMessageJob())->everyFiveMinutes();
        $schedule->job(new SchedulingSeminarJob())->everyFiveMinutes();
        $schedule->job(new SchedulingRequireFeedbackJob())->everyFiveMinutes();
        $schedule->job(new SchedulingEventJob())->everyFiveMinutes();

        $schedule->job(new CleanUpFeedbackJob())->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
