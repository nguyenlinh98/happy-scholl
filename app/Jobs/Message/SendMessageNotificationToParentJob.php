<?php

namespace App\Jobs\Message;

use App\Jobs\NotifyViaFirebaseJob;
use App\Models\Message;
use App\Models\MessageReadStatus;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendMessageNotificationToParentJob implements ShouldQueue
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
    public $message;

    public function __construct(Student $student, Message $message)
    {
        $student->loadMissing('parents');
        $this->student = $student;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->createMessageReadStatusPerStudent();
        $this->sendViaFirebase();
    }

    public function createMessageReadStatusPerStudent()
    {
        $status = new MessageReadStatus();
        $status->message_id = $this->message->id;
        $status->student_id = $this->student->id;
        $status->school_id = $this->message->school_id;
        $status->read = MessageReadStatus::STATUS_UNREAD;
        $status->save();
    }

    public function sendViaFirebase()
    {
        if ($this->student->hasParents) {
            info('[SendMessageNotificationToParentJob.sendViaFirebase] Start...'.json_encode($this->student->parent));
            foreach ($this->student->parents as $parent) {
                dispatch(new NotifyViaFirebaseJob($parent, config('message.push_setting'), $this->message->subject, Str::limit($this->message->body, config('message.body_limit', 100))));
            }
            info('[SendMessageNotificationToParentJob.sendViaFirebase] End...');
        }
    }
}
