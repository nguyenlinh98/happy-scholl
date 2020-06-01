<?php

namespace App\Jobs\RequireFeedback;

use App\Models\RequireFeedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanUpFeedbackJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;
    
    protected $version = 'v1.0.1';

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
        info(self::class, [$this->version]);

        $requireFeedbacks = RequireFeedback::whereDate('clean_up_at', '<', today())->where('status', RequireFeedback::STATUS_DISTRIBUTED)->get();
        foreach ($requireFeedbacks as $requireFeedback) {
            logger([self::class, 'handle', 'calling clean up method on requireFeedback', ['id' => $requireFeedback->id]]);
            $requireFeedback->cleaningResponse();
        }
    }
}
