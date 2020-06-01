<?php

namespace App\Jobs\Meeting;

use App\Jobs\NotifyViaFirebaseJob;
use App\Models\Meeting;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendNotificationToParentOfStudentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public $student;
    public $meeting;

    public function __construct(Student $student, Meeting $meeting)
    {
        info('[SendNotificationToParentOfStudentJob.__construct] student_id...'.(empty($student) ? null : $student->id));
        $this->student = $student;
        $this->meeting = $meeting;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->sendViaFirebase();
    }

    private function sendViaFirebase()
    {
        if ($this->student->hasParents) {
            info('[SendNotificationToParentOfStudentJob.sendViaFirebase] Start...');
            foreach ($this->student->parents as $parent) {
                dispatch(new NotifyViaFirebaseJob($parent, config('letter.push_setting'), $this->meeting->subject, Str::limit($this->meeting->body, config('meeting.body_limit', 100))));
            }
            info('[SendNotificationToParentOfStudentJob.sendViaFirebase] End...');
        }
    }
}
