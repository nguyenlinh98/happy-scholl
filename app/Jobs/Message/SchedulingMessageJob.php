<?php

namespace App\Jobs\Message;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulingMessageJob implements ShouldQueue
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
        $distributingMessages = Message::where('scheduled_at', '<=', now())->where('status', Message::STATUS_NOT_YET)->get();
        foreach ($distributingMessages as $message) {
            echo "message id: ".$message->id."\n";
            dispatch(new DistributeMessageJob($message));
        }
    }
}
