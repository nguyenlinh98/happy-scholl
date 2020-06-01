<?php

namespace App\Jobs\Message;

use App\Models\ClassGroup;
use App\Models\Message;
use App\Models\SchoolClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class DistributeMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;
    
    /**
     * Create a new job instance.
     */
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->startProcessingMessage();
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('[DistributeMessageJob.handle] Start...');
        $students = $this->getStudents();
        foreach ($students as $student) {
            dispatch(new SendMessageNotificationToParentJob($student, $this->message));
        }
        Log::info('[DistributeMessageJob.handle] Start...');
    }

    public function getStudents()
    {
        $students = collect([]);
        foreach ($this->message->receivers as $receiver) {
            if (ClassGroup::class === $receiver->receiver_type) {
                $receiver->loadMissing(['receiver', 'receiver.classes', 'receivers.classes.students']);
                $students = $students->merge($receiver->pluck('receiver.classes.students')->flatten(2));
            }
            if (SchoolClass::class === $receiver->receiver_type) {
                $receiver->loadMissing(['receiver', 'receiver.students']);
                $students = $students->merge($receiver->receiver->students);
            }
        }

        return $students;
    }

    private function startProcessingMessage()
    {
        $this->message->status = Message::STATUS_IN_PROGRESS;
        $this->message->save();
    }
}
