<?php

namespace App\Jobs\Meeting;

use App\Models\Meeting;
use App\Models\MeetingReadStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DistributeMeetingJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public $meeting;

    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        info('[DistributeMeetingJob.handle] Start...');
        $this->createStudentReadStatuses();
        $this->markMeetingAsSent();
        info('[DistributeMeetingJob.handle] End...');
    }

    public function createStudentReadStatuses()
    {
        $students = $this->meeting->students()->get();
        foreach ($students as $student) {
            $readStatus = new MeetingReadStatus();
            $readStatus->letter_id = $this->meeting->id;
            $readStatus->school_id = $student->school_id;
            $readStatus->student_id = $student->id;
            $readStatus->read = MeetingReadStatus::STATUS_UNREAD;
            $readStatus->favorist_flag = 0;
            $readStatus->save();
            if ($student->hasParents) {
                dispatch(new SendNotificationToParentOfStudentJob($student, $this->meeting));
            }
        }
    }

    public function markMeetingAsSent()
    {
        $this->meeting->status = Meeting::STATUS_SENT;
        $this->meeting->save();
    }
}
