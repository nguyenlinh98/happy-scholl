<?php

namespace App\Jobs\RequireFeedback;

use App\Models\RequireFeedback;
use App\Models\RequireFeedbackStatuses;
use App\Notifications\SendRequireFeedbackNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class DistributingRequireFeedbackJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;
    
    /**
     * Create a new job instance.
     */
    public $requireFeedback;

    public function __construct(RequireFeedback $requireFeedback)
    {
        info(self::class.'::_construct:start');
        $this->requireFeedback = $requireFeedback;
        info(self::class.'::_construct:end');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        info(self::class.'::handle:start');
        $this->createStudentRequireFeedbackStatuses();
        $this->sendToStudents();

        $this->requireFeedback->markAsDistributed();

        info(self::class.'::handle:end');
    }

    public function createStudentRequireFeedbackStatuses()
    {
        $students = $this->requireFeedback->students;
        foreach ($students as $student) {
            $feedbackStatus = new RequireFeedbackStatuses();
            $feedbackStatus->require_feedback_id = $this->requireFeedback->id;
            $feedbackStatus->school_id = $student->school_id;
            $feedbackStatus->student_id = $student->id;
            $feedbackStatus->feedback = RequireFeedbackStatuses::STATUS_NOTYET;
            $feedbackStatus->save();
        }
    }

    /**
     * Send to all student belongs to this feedback class list.
     */
    public function sendToStudents()
    {
        $students = $this->requireFeedback->students;
        foreach ($students as $student) {
            if ($student->hasParents) {
                Notification::send($student->parents, new SendRequireFeedbackNotification($this->requireFeedback));
            }
        }
    }
}
