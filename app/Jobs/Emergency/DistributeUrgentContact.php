<?php

namespace App\Jobs\Emergency;

use App\Models\UrgentContact;
use App\Models\UrgentContactReceiver;
use App\Models\SchoolClass;
use App\Models\UrgentContactDetailStatus;
use App\Jobs\Emergency\SendUrgentContactToParentOfStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Str;

class DistributeUrgentContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $urgentContact;

    public $questionnaire;

    public $students;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UrgentContact $urgentContact)
    {
        // Must extract questionnaire as it will be vanish if this model is to be serialized.
        $this->urgentContact = $urgentContact;

        $this->questionnaire = $urgentContact->questionnaire;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('[DistributeUrgentContactJob.handle] Start...');
        $this->distributesUrgentToReceivers();
        info('[DistributeUrgentContactJob.handle] End...');
    }

    public function distributesUrgentToReceivers()
    {
        foreach ($this->urgentContact->receivers as $receiver) {
            $receiver->loadMissing(['receiver', 'receiver.students']);
            $this->markUrgentContactReceiverAsSent($receiver, UrgentContactReceiver::STATUS_IN_PROGRESS);

            try {
                $this->initializesReadStatusAndSendsToParents($receiver->receiver->students);
            } catch (\Exception $e) {
                $this->markUrgentContactReceiverAsSent($receiver, UrgentContactReceiver::STATUS_ERROR);
            }
                $this->markUrgentContactReceiverAsSent($receiver, UrgentContactReceiver::STATUS_FINISH);
        }
    }

    public function initializesReadStatusAndSendsToParents($students)
    {
        foreach ($students as $student) {
            foreach($this->questionnaire as $questionID => $question) {
                UrgentContactDetailStatus::create([
                    'urgent_contact_id' => $this->urgentContact->id,
                    'student_id' =>$student->id,
                    'school_id' => $student->school_id,
                    'status' => UrgentContactDetailStatus::STATUS_UNREAD,
                    'question_id' => $questionID,
                    'question_type' => Str::startsWith($questionID, UrgentContact::YESNO) ? UrgentContactDetailStatus::TYPE_YESNO : UrgentContactDetailStatus::TYPE_INPUT,
                    'question_text' => $question,
                ]);
            }

            SendUrgentContactToParentOfStudent::dispatch($student, $this->urgentContact);
        }
    }

    public function markUrgentContactReceiverAsSent($receiver, $status)
    {
        return $receiver->update(['status' => $status]);
    }
}
