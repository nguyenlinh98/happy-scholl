<?php

namespace App\Jobs\RequireFeedback;

use App\Models\RequireFeedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulingRequireFeedbackJob implements ShouldQueue
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
        info(self::class.'::handle:start');

        $distributingRequireFeedbacks = RequireFeedback::where('scheduled_at', '<=', now())->where('status', RequireFeedback::STATUS_NOT_YET)->get();
        foreach ($distributingRequireFeedbacks as $requireFeedback) {
            echo "requireFeedback id: ".$requireFeedback->id."\n";
            logger([self::class, 'handle', 'dispatching DistributingRequireFeedbackJob', $requireFeedback->toArray()]);
            dispatch(new DistributingRequireFeedbackJob($requireFeedback));
        }
        info(self::class.'::handle:end');
    }
}
