<?php

namespace App\Jobs\Seminar;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DistributeSeminarJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;
    
    /**
     * Create a new job instance.
     */
    public $seminar;

    public function __construct(Seminar $seminar)
    {
        $this->seminar = $seminar;
        $this->seminar->loadMissing('students');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //TODO: Send seminar notification to parent
    }
}
