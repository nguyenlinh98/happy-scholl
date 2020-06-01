<?php

namespace App\Jobs\CalendarEvent;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulingEventJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $version = '1.0.0';

    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $unsentEvents = Event::awaitingReminds()->withoutHSPCalendar()->get();
        foreach ($unsentEvents as $event) {
            if ($event->dueToRemind()) {
                dispatch(new SendEventReminderJob($event));
            }
        }
    }
}
