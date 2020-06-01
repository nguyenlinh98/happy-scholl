<?php

namespace App\Jobs\Seminar;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulingSeminarJob implements ShouldQueue
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
        $scheduledToRunSeminars = Seminar::where('status', Seminar::STATUS_RESERVATION)->get();
        foreach ($scheduledToRunSeminars as $seminar) {
            dispatch(new DistributeSeminarJob($seminar));
        }
    }
}
