<?php

namespace App\Jobs\Letter;

use App\Models\Letter;
use App\Models\LetterReadStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DistributeLetterJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;
    
    /**
     * Create a new job instance.
     */
    public $letter;

    public function __construct(Letter $letter)
    {
        $this->letter = $letter;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        info('[DistributeLetterJob.handle] Start...');
        $this->createStudentReadStatuses();
        $this->markLetterAsSent();
        info('[DistributeLetterJob.handle] End...');
    }

    public function createStudentReadStatuses()
    {
        $students = $this->letter->students()->get();
        foreach ($students as $student) {
            $readStatus = new LetterReadStatus();
            $readStatus->letter_id = $this->letter->id;
            $readStatus->school_id = $student->school_id;
            $readStatus->student_id = $student->id;
            $readStatus->read = LetterReadStatus::STATUS_UNREAD;
            $readStatus->favorist_flag = 0;
            $readStatus->save();
            if ($student->hasParents) {
                dispatch(new SendNotificationToParentOfStudentJob($student, $this->letter));
            }
        }
    }

    public function markLetterAsSent()
    {
        $this->letter->status = Letter::STATUS_SENT;
        $this->letter->save();
    }
}
