<?php

namespace App\Jobs\Letter;

use App\Models\Letter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulingLetterJob implements ShouldQueue
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
        $distributingLetters = Letter::where('scheduled_at', '<=', now())->where('status', Letter::STATUS_CREATED)->get();
        foreach ($distributingLetters as $letter) {
            echo "letter id: ".$letter->id."\n";
            dispatch(new DistributeLetterJob($letter));
        }
    }
}
