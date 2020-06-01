<?php

namespace App\Jobs\Meeting;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulingMeetingJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $distributingMeetings = Meeting::where('scheduled_at', '<=', now())->where('status', Meeting::STATUS_CREATED)->get();
        foreach ($distributingMeetings as $meeting) {
            echo 'letter id: '.$meeting->id."\n";
            dispatch(new DistributeMeetingJob($meeting));
        }
    }
}
