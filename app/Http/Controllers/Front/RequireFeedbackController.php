<?php

namespace App\Http\Controllers\Front;

use App\Models\RequireFeedback;
use App\Models\RequireFeedbackStatuses;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class RequireFeedbackController extends Controller
{
    // const GROUP_CLASS = 1;
    const CLASS_ID = 'App\Models\SchoolClass';
     const STUDENT = 3;
    const FeedBackNotYet = 0;
    const FeedBackOK = 1;
    const FeedBackNG = 2;


    protected $requireFeedback;

    protected $student;

    protected $requireFeedbackStatuses;

    public function __construct(
        RequireFeedback $requireFeedback,
        Student $student,
        RequireFeedbackStatuses $requireFeedbackStatuses
    )
    {
        $this->requireFeedback = $requireFeedback;
        $this->student = $student;
        $this->requireFeedbackStatuses = $requireFeedbackStatuses;
    }

    public function getList($studentId)
    {
        Log::info('[RequireFeedbackController.getList] Start...');
        $student = $this->student->find($studentId);

        if (!$student) {
            Log::info('[RequireFeedbackController.getList] End...');
            return redirect()->route('front.mypage.index');
        }

        if ($student->school_id != getSchool()->id) {
            Log::info('[RequireFeedbackController.getList] End...');
            return redirect()->route('front.school.choose');
        }

        $requireFeedback = $this->requireFeedback->whereHas('receivers', function ($q) use ($student) {
            /*$q->where(function ($q1) use ($student) {
                $q1->where('receiver_type', self::STUDENT)->where('receiver_id', $student->id);
            })->orWhere(function ($q2) use ($student) {
                $q2->where('receiver_type', self::CLASS_ID)->where('receiver_id', $student->school_class_id);
            });
            */
            $q->where(function ($q) use ($student) {
                $q->where('receiver_type', self::CLASS_ID)->where('receiver_id', $student->school_class_id);
            });
        })->orderBy('scheduled_at', 'DESC')->get();
        Log::info('[RequireFeedbackController.getList] End...');

        return view('front.require_feedback.list', compact('requireFeedback', 'studentId'));
    }

    public function success(Request $request, $studentId, $feedbackId)
    {
        Log::info('[RequireFeedbackController.success] Start...');
        $student = $this->student->find($studentId);

        if (!$student) {
            Log::info('[RequireFeedbackController.success] End...');
            return redirect()->route('front.mypage.index');
        }

        if ($student->school_id != getSchool()->id) {
            Log::info('[RequireFeedbackController.success] End...');
            return redirect()->route('front.school.choose');
        }

        $requireFeedback = $this->requireFeedback->find($feedbackId);

        if (!$requireFeedback) {
            Log::info('[RequireFeedbackController.success] End...');
            return redirect()->route('front.require_feedback.list', $studentId);
        }

        $receivers = [];
        if ($requireFeedback) {
            $receivers = $requireFeedback->receivers->first();
        }

        // if ($receivers && $receivers->receiver_type == self::STUDENT) {
        //     if ($receivers->receiver_id != $studentId) {
        //         Log::info('[RequireFeedbackController.success] End...');
        //         return redirect()->route('front.mypage.index');
        //     }
        // }
        if ($receivers && $receivers->receiver_type == self::CLASS_ID) {
            if ($receivers->receiver_id != $student->school_class_id) {
                Log::info('[RequireFeedbackController.success] End...');
                return redirect()->route('front.mypage.index');
            }
        }

        //save data

        $resultFeedback = self::FeedBackNotYet;

        if ($request->btn == 'yes') {
            $resultFeedback = self::FeedBackOK;
        }
        if ($request->btn == 'no') {
            $resultFeedback = self::FeedBackNG;
        }
        $status = $this->requireFeedbackStatuses->getDataByFeedBackIdAndStudentId($feedbackId, $studentId);
        if (!$status) {
            $status = $this->requireFeedbackStatuses;
            $status->require_feedback_id = $feedbackId;
            $status->student_id = $studentId;
            $status->school_id = $student->school_id;
        }
        $status->feedback = $resultFeedback;
        $status->save();

        Log::info('[RequireFeedbackController.success] End...');
        return view('front.require_feedback.complete', compact('student'));

    }
}
