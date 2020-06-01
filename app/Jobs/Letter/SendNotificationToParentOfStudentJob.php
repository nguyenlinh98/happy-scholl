<?php

namespace App\Jobs\Letter;

use App\Jobs\NotifyViaFirebaseJob;
use App\Models\Letter;
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
    public $letter;

    public function __construct(Student $student, Letter $letter)
    {
        info('[SendNotificationToParentOfStudentJob.__construct] student_id...'.(empty($student) ? null : $student->id));
        $this->student = $student;
        $this->letter = $letter;
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
                dispatch(new NotifyViaFirebaseJob($parent, config('letter.push_setting'), $this->letter->subject, Str::limit($this->letter->body, config('letter.body_limit'))));
            }
            info('[SendNotificationToParentOfStudentJob.sendViaFirebase] End...');
        }
    }
}
