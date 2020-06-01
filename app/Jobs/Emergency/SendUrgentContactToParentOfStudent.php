<?php

namespace App\Jobs\Emergency;

use App\Jobs\NotifyViaFirebaseJob;
use App\Models\UrgentContact;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Str;

class SendUrgentContactToParentOfStudent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $student;

    public $urgentContact;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Student $student, UrgentContact $urgentContact)
    {
        $student->loadMissing('parents');
        info('[SendUrgentContactToParentOfStudentJob.__construct] student_id...'.(empty($student) ? null : $student->id));
        $this->student = $student;
        $this->urgentContact = $urgentContact;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->sendViaFirebase();
            info('[SendUrgentContactToParentOfStudentJob.sendViaFirebase] End...');
    }

    private function sendViaFirebase()
    {
        if ($this->student->hasParents) {
            foreach ($this->student->parents as $parent) {
                dispatch(new NotifyViaFirebaseJob($parent, config('urgent.push_setting'), $this->urgentContact->subject, Str::limit($this->urgentContact->subject, config('urgent.body_limit'))));
            }
        }
    }
}
