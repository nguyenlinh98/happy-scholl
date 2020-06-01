<?php
/**
 * User: JohnAVu
 * Date: 2019-12-27
 * Time: 10:41
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\SchoolPasscode;
use Illuminate\Http\Request;
use App\Models\PassCode;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected $schoolPasscode;
    protected $passCode;

    public function __construct(SchoolPasscode $schoolPasscode, PassCode $passCode)
    {
        $this->schoolPasscode = $schoolPasscode;
        $this->passCode = $passCode;
    }

    public function chooseSchool()
    {
        Log::info('[SchoolController.chooseSchool] Start...');
        $listSchools = [];

        $students = \Auth::guard('parents')->user()->student;
        foreach ($students as $student) {
            if ($student->schoolClass) {
                if ($student->schoolClass->school) {
                    $school = $student->schoolClass->school;
                    $listSchools[$school->id]['name'] = $school->name;
                    $listSchools[$school->id]['order'] = $school->display_order;

                }
            }
        }
        $listSchools = sortDataBy($listSchools, 'order');
        Log::info('[SchoolController.chooseSchool] End...');
        return view('front.schools.choose', compact('listSchools'));
    }

    /**
     * @param $school_id
     */
    public function actionChooseSchool($school_id)
    {
        Log::info('[SchoolController.actionChooseSchool] Start...');
        Session::put('school_id', $school_id);
        Log::info('[SchoolController.actionChooseSchool] End...');
        return redirect()->route('front.mypage.index');
    }

    public function schoolPassCode()
    {
        Log::info('[SchoolController.schoolPassCode] Start...');
        $passcode = '';
        $data = \Session::get('register');
        if (isset($data['schoolPasscode'])) {
            $passcode = $data['schoolPasscode'];
        }
        Log::info('[SchoolController.schoolPassCode] End...');
        return view('front.schools.passcode_school')->with('passcode', $passcode);
    }

    public function postSchoolPassCode(Request $request)
    {
        // validate
        Log::info('[SchoolController.postSchoolPassCode] Start...');
        $request->validate([
            'schoolPasscode' => 'required|regex:/^(?=.*?[a-z]{1})(?=.*?[0-9]{4})/',
        ], [
            'required' =>  translate('パスコードが必要です'),
            'regex' => translate('パスコードには4桁の数字と1つの小文字が含まれます')
        ]);
        // $request->validate([
        //     'school_check' => 'required',
        // ], [
        //     'required' => 'チェックボックスが必要です'
        // ]);

        //validate passcode is not exist or used
        $passCode = $this->schoolPasscode->getActivePasscode($request->get('schoolPasscode'));
        if (!$passCode) {
            Log::info('[SchoolController.postSchoolPassCode] End...');
            return redirect()->route('front.school.passcodeschool')
                ->withErrors(['パスコードがアクティブではありません']);
        }
        //save data to Session
        \Session::put('select_school', $request->all());
        Log::info('[SchoolController.postSchoolPassCode] End...');
        return redirect()->route('front.school.passcodestudent');
    }

    public function studentPassCode(Request $request)
    {
        Log::info('[SchoolController.studentPassCode] Start...');
        $passcode = '';
        $data = \Session::get('select_school');
        $schoolName = $this->schoolPasscode->getSchoolName($data['schoolPasscode']);
        if (isset($data['schoolPasscode'])) {
            if (isset($data['passcode'])) {
                $passcode = $data['passcode'];
            }
            Log::info('[SchoolController.studentPassCode] End...');
            return view('front.schools.passcode_student')->with(['passcode' => $passcode, 'schoolName' => $schoolName]);
        } else {
            Log::info('[ResetPasswordController.studentPassCodes] End...');
            return redirect()->route('front.school.passcodeschool');
        }
    }

    public function postStudentPassCode(Request $request)
    {
        // validate
        Log::info('[SchoolController.postStudentPassCode] Start...');
        $request->validate([
            'passcode' => 'required|size:7|regex:/^(?=.*?[0-9a-zA-Z]{7})/',
        ], [
            'required' => 'パスコードが必要です',
            'size' => 'パスコードには7桁が含まれます',
            'regex' => 'パスコードには7桁が含まれます'
        ]);

        //validate passcode is not exist or used
        $passCode = $this->passCode->getActivePasscode($request->get('passcode'));
        if (!$passCode) {
            Log::info('[SchoolController.postStudentPassCode] End...');
            return redirect()->route('front.school.passcodestudent')
                ->withErrors(['パスコードはこの学生のものではありません']);
        }
        if (!$passCode->student) {
            Log::info('[SchoolController.postStudentPassCode] End...');
            return redirect()->route('front.school.passcodestudent')->withErrors(['学生はこのクラスのものではありません']);
        }
        if (!$passCode->student->schoolClass) {
            Log::info('[SchoolController.postStudentPassCode] End...');
            return redirect()->route('front.school.passcodestudent')->withErrors(['学生はこのクラスのものではありません']);
        }
        if (!$passCode->student->schoolClass->school) {
            Log::info('[SchoolController.postStudentPassCode] End...');
            return redirect()->route('front.school.passcodestudent')->withErrors(['クラスはこの学校のものではありません']);
        }

        $data = \Session::get('select_school');
        $schoolId = $this->schoolPasscode->getSchoolByPasscode($passCode->student->school_id, $data['schoolPasscode']);
        if ($schoolId == 0) {
            Log::info('[SchoolController.postStudentPassCode] End...');
            return redirect()->route('front.school.passcodestudent')->withErrors(['学生はこの学校のものではありません']);
        }
        if ($data['schoolPasscode']) {
            $request->request->add(['schoolPasscode' => $data['schoolPasscode']]);
        }

        DB::transaction(function () use ($passCode) {
            $parent = Auth::guard('parents')->user();
            $parent->student()->attach($passCode->student->id);
            // Comment for changed spec - no need to deactive
            //$passCode->used = $passCode->used + 1;
            $passCode->save();
        });
        //save data to Session
        \Session::put('select_school', $request->all());

        Log::info('[SchoolController.postStudentPassCode] End...');
        return view('front.schools.passcode_complete');
    }
}
