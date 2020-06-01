<?php
/**
 * User: JohnAVu
 * Date: 2019-12-27
 * Time: 13:22
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\RecycleProduct;
use App\Models\RequireFeedbackStatuses;
use App\Models\School;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Letter;
use App\Models\Message;
use App\Models\UrgentContactDetailStatus;

class MyPageController extends Controller
{

    /**
     * @var School
     */
    protected $school;

    /**
     * @var SchoolSetting
     */
    protected $schoolSetting;

    /**
     * @var RequireFeedbackStatuses
     */
    protected $requireFeedbackStatuses;

    /**
     * @var RecycleProduct
     */
    protected $recycleProduct;

    /**
     * MyPageController constructor.
     * @param School $school
     * @param SchoolSetting $schoolSetting
     * @param RequireFeedbackStatuses $requireFeedbackStatuses
     * @param RecycleProduct $recycleProduct
     */
    public function __construct(
        School $school,
        SchoolSetting $schoolSetting,
        RequireFeedbackStatuses $requireFeedbackStatuses,
        RecycleProduct $recycleProduct
    )
    {
        $this->school = $school;
        $this->schoolSetting = $schoolSetting;
        $this->requireFeedbackStatuses = $requireFeedbackStatuses;
        $this->recycleProduct = $recycleProduct;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        Log::info('[MyPageController.index] Start...');
        if (!Session::get('school_id')) {
            return redirect()->route('front.school.choose');
        }

        $schoolId = Session::get('school_id');
        $school = $this->getSchool($schoolId);
        $studentSchool = $school->student;

        $parents = Auth::guard('parents')->user();
        $studentParents = $parents->student;
        //Check student get by school_id and student get by user login
        $students = $this->checkStudentOfParents($studentParents, $studentSchool);
        // remove duplicate if data dumpy
        $students = $students->unique('id');

        // array count letter and message of student
        $arrLetterCount = $arrMessageCount = $arrRequireFeedback = $arrCountSurvey = [];
        if ($students->count() > 0) {
            foreach ($students as $item) {
                $countLetter = Letter::countLetterByStudent($item->id);
                $countMessage = Message::countMessageByStudent($item->id);
                $countRequireFeedback = $this->requireFeedbackStatuses->getCountNotReadByStudent($item->id);
                $arrLetterCount[$item->id] = $countLetter;
                $arrMessageCount[$item->id] = $countMessage;
                $arrRequireFeedback[$item->id] = $countRequireFeedback;
                $rsQuestion = UrgentContactDetailStatus::getQuestionsByStudent($item->id);
                if($rsQuestion->count() > 0) {
                    $item->check_question_exist = 1;
                    // count survey for each student and return to array
                    foreach($rsQuestion as $rsQ) {
                        $arrCountSurvey[$rsQ->student_id][] = $rsQ->urgent_contact_id;
                    }
                }
            }
        }

        //get recycle product
        $recycleProduct = $this->recycleProduct->getSellingProduct($schoolId, $parents->id);
        $list = $this->recycleProduct->where(function ($q) use ($parents) {
            $q->where('user_id', $parents->id)
                ->orWhereHas('applyStatus', function ($q1) use ($parents) {
                    $q1->where('status', '<', 5)->where('user_id', $parents->id);
                });
        })
            ->where('status', '!=', '0')
            ->where('status', '!=', 5)
            ->where('school_id', getSchool()->id)
            ->where('updated_at', '>', Carbon::now()->subMonth()->toDateTimeString())
            ->count();
        $userSetting = $parents->setting->first();
        $schoolSetting = $this->schoolSetting->getBySchoolId($schoolId);
        Log::info('[MyPageController.index] End...');
        return view('front.mypage.index', compact('students', 'school', 'arrLetterCount', 'arrMessageCount', 'userSetting', 'schoolSetting', 'arrRequireFeedback', 'list', 'parents','arrCountSurvey'));
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getSchool($id)
    {
        return $this->school->find($id);
    }

    /**
     * @param $studentParents
     * @param $studentSchool
     * @return \Illuminate\Support\Collection
     */
    private function checkStudentOfParents($studentParents, $studentSchool)
    {
        Log::info('[MyPageController.checkStudentOfParents] Start...');
        $studentDupes = collect([]);
        $studentParents->each(function ($item) use ($studentSchool, $studentDupes) {
            if ($studentSchool->contains($item) !== false) {
                $studentDupes->push($item);
            }
        });
        Log::info('[MyPageController.checkStudentOfParents] End...');
        return $studentDupes;
    }
}
