<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\UrgentContact;
use App\Models\UrgentContactReceiver;
use App\Models\UrgentContactDetailStatus;
use App\Http\Requests\CreateUrgentContact as CreateUrgentRequest;
use App\Events\HasEmergencySituation;

class EmergencyController extends Controller
{
    public function create()
    {
        $urgentContact = UrgentContact::getInstanceWithQuestions();

        $polarQuestions = $urgentContact->general_questions;

        $whQuestions = $urgentContact->special_questions;

        //$schoolClasses = auth()->user()->schoolClasses()->get();
        $schoolClasses = auth()->user()->schoolClasses();

        return view('front.emergencies.create', [
            'yesNoQuestions' => $polarQuestions,
            'inputQuestions' => $whQuestions,
            'schoolClasses' => $schoolClasses,
        ]);
    }

    public function review(CreateUrgentRequest $request)
    {
        $urgentContact = UrgentContact::prepareForReview($request);

        return view('front.emergencies.review', ['urgentContact' => $urgentContact]);
    }

    public function store(CreateUrgentRequest $request)
    {
        if ('return' === $request->input('reject')) {
            // only on review
            // if user want to edit, redirect back to create page
            return redirect()->route('emergency.create')->withInput();
        }

        event(new HasEmergencySituation(
            $urgentContact = UrgentContact::makeInstanceWithQuestions($request)
        ));

        return redirect()->route('emergency.complete')->with(['urgent_contact' => $urgentContact]);
    }

    public function complete()
    {
        return view('front.emergencies.sent', ['urgentContact' => session()->get('urgent_contact')]);
    }

    public function index()
    {
        // Still need query 'where' if UrgentContact use SchoolScopeTrait and the current user is a school admin ???
        $urgentContacts = UrgentContact::where('school_id', auth()->user()->school_id)
                            ->orderBy('created_at', 'DESC')->get();

        return view('front.emergencies.index', ['urgentContacts' => $urgentContacts]);
    }

    public function showClasses($emergencyId)
    {
        // Get all receivers (school class) of selected urgent contact and sort by class name.
        $schoolClasses = UrgentContact
                            ::find($emergencyId)
                            ->receivers->pluck('receiver')
                            ->sortBy('name')->values();

        return view('front.emergencies.show', [
            'schoolClasses' => $schoolClasses,
            'emergencyId' => $emergencyId
        ]);
    }

    public function showQuestions($emergencyId, $classId)
    {
        if (0 == $classId) {
            return $this->showQuestionsForAll($emergencyId, $classId);
        }

        $className = SchoolClass::find($classId)->name;
        // Just pick a random student in the class.
        $classStudent = SchoolClass::find($classId)->students()->first();

        $questionnaire = UrgentContactDetailStatus
                            ::select('question_id', 'question_text', 'urgent_contact_id')
                            ->where([
                                ['urgent_contact_id', '=', $emergencyId],
                                ['student_id', '=', $classStudent->id],
                            ])->get();

        return view('front.emergencies.class-show', [
            'className' => $className,
            'questionnaire' => $questionnaire,
            'emergencyId' => $emergencyId,
            'classId' => $classId
        ]);
    }

    private function showQuestionsForAll($emergencyId, $classId) {
        $className = '全体';
        // Just pick a random student whom current teacher is in charge of managing and has been sent this urgent.
        $studentWasSent = UrgentContactDetailStatus::where('urgent_contact_id', '=', $emergencyId)->get()->random()->student;

        $questionnaire = UrgentContactDetailStatus
                            ::select('question_id', 'question_text', 'urgent_contact_id')
                            ->where([
                                ['urgent_contact_id', '=', $emergencyId],
                                ['student_id', '=', $studentWasSent->id],
                            ])->get();

        return view('front.emergencies.class-show', [
            'className' => $className,
            'questionnaire' => $questionnaire,
            'emergencyId' => $emergencyId,
            'classId' => $classId
        ]);
    }

    public function showAnswers($emergencyId, $classId, $questionParam)
    {
        if (true === request()->has('detail')) {
            return view('front.emergencies.answer-detail', [ 'details' => request()->input()]);
        }

        if (0 == $classId) {
            return $this->showAnswersForAll($emergencyId, $classId, $questionParam);
        }

        $className = SchoolClass::find($classId)->name;

        $classStudentIds = UrgentContact
                            ::find($emergencyId)
                            ->receivers->where('receiver_id', $classId)
                            ->pluck('receiver.students')->flatten(2)
                            ->pluck('id');

        $answerQuery = UrgentContactDetailStatus::with(['student'])
                        ->where('urgent_contact_id', '=', $emergencyId)
                        ->where('question_id', $this->getQuestionId($questionParam))
                        ->whereIn('student_id', $classStudentIds);

        $answers = $answerQuery->get();

        $notYetAnswerCount = $answerQuery->where('status', '=', UrgentContactDetailStatus::STATUS_UNREAD)->count();

        return view('front.emergencies.question-show', [
            'answers' => $answers,
            'className' => $className,
            'noStudent' => count($classStudentIds),
            'notYetAnswerCount' => $notYetAnswerCount,
            'emergencyId' => $emergencyId,
            'classId' => $classId,
        ]);
    }

    private function showAnswersForAll($emergencyId, $classId, $questionParam)
    {
        $className = '全体';

        $classStudentIds = UrgentContact
                            ::find($emergencyId)
                            ->receivers
                            ->pluck('receiver.students')->flatten(2)
                            ->pluck('id');

        $answerQuery = UrgentContactDetailStatus::with(['student'])
                        ->where('urgent_contact_id', '=', $emergencyId)
                        ->where('question_id', $this->getQuestionId($questionParam))
                        ->whereIn('student_id', $classStudentIds);

        $answers = $answerQuery->get();

        $notYetAnswerCount = $answerQuery->where('status', '=', UrgentContactDetailStatus::STATUS_UNREAD)->count();

        return view('front.emergencies.question-show', [
            'answers' => $answers,
            'className' => $className,
            'noStudent' => count($classStudentIds),
            'notYetAnswerCount' => $notYetAnswerCount,
            'emergencyId' => $emergencyId,
            'classId' => $classId,
        ]);
    }

    public function showAnswerMore()
    {
        return view('front.emergencies.answer-detail', [
            'className' => request('school_class'),
            'studentName' => request('student'),
            'answerText' => request('answer_text'),
        ]);
    }

    private function getQuestionId($questionParam)
    {
        return strtoupper($questionParam);
    }

    // for parent login front-end
    public function studentQuestion($contact_id, $student_id)
    {
        $rsQuestion = UrgentContactDetailStatus::getQuestionsByContactAndStudent($contact_id, $student_id);
        $rsQuestion = $rsQuestion->sortBy('question_type');

        return view('front.emergencies.student-questions', compact('rsQuestion', 'contact_id', 'student_id'));
    }

    public function confirmStudentAnswer(Request $request,$contact_id, $student_id)
    {
        $data = []; // store all answers
        $rs = $request->all();
        // validate to all yes-no answer
        if(isset($rs['question_answer_yes_no']) && count($rs['question_answer_yes_no']) > 0) {
            foreach($rs['question_answer_yes_no'] as $key1 => $yes_no_val) {
                if(is_null($yes_no_val)) {
                    return redirect()->route('emergency.student-questions', [$contact_id, $student_id])
                        ->withErrors(['「YES」と「NO」の質問内容にご回答ください。']);
                } else {
                    $data[$key1] = ['yesno_answer' => $yes_no_val];
                   // UrgentContactDetailStatus::where('id', $key1)->update($data);
                }
            }
        }

        if(isset($rs['question_answer_text']) && count($rs['question_answer_text']) > 0) {
            foreach($rs['question_answer_text'] as $key2 => $text_val) {
                if(is_null($text_val) || empty($text_val)) {
                    $text_val = '';
                }
                $data[$key2] = ['answer_text' => trim($text_val)];
            }
        }
        $rsDataQuestion = UrgentContactDetailStatus::where('student_id', $student_id)
                                            ->pluck('question_text', 'id')->toArray();

        return view('front.emergencies.student-answer-confirm', compact('data', 'student_id','rsDataQuestion'));
    }

    public function saveStudentAnswer(Request $request, $student_id)
    {
        $rs = $request->get('question_answer');
        foreach($rs as $key => $item) {
            // return array of one answer and update
            $answer_value = json_decode($item, true);
            $answer_value['status'] = 1;
            UrgentContactDetailStatus::where('id', $key)->update($answer_value);
        }

        return view('front.emergencies.student-answer-complete');
    }

    public function questionStudentCategory($student_id)
    {
        $rsQuestion = UrgentContactDetailStatus::getQuestionsByStudent($student_id);
        $urgent_contact = [];
        if($rsQuestion->count() > 0) {
            foreach($rsQuestion as $rs) {
                if($rs->urgentContact) {
                    $urgent_contact[$rs->urgentContact->id] = $rs->urgentContact->subject;
                }
            }
        }
        $urgent_contact = array_unique($urgent_contact);
        return view('front.emergencies.student-questions-category', compact('urgent_contact', 'student_id'));
    }
}
