<?php
/**
 * User: JohnAVu
 * Date: 2019-12-20
 * Time: 14:02
 */

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Parents;
use App\Models\PassCode;
use App\Models\UserSetting;
use App\Models\SchoolPasscode;
use App\Notifications\CompletedAccount;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Front\Auth
 */
class RegisterController extends Controller
{
    protected $eventBgcolor = '#FFF';

    /**
     * @var PassCode
     */
    protected $passCode;
    protected $schoolPasscode;

    /**
     * @var Parent
     */
    protected $customer;

    /**
     * @var Calendar
     */
    protected $calendar;

    /**
     * RegisterController constructor.
     * @param PassCode $passCode
     * @param Parents $customer
     * @param Calendar $calendar
     */
    public function __construct(
        PassCode $passCode,
        Parents $customer,
        Calendar $calendar,
        SchoolPasscode $schoolPasscode
    )
    {
        $this->passCode = $passCode;
        $this->customer = $customer;
        $this->calendar = $calendar;
        $this->schoolPasscode = $schoolPasscode;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        Log::info('[RegisterController.index] Start...');
        return redirect()->route('register.schoolpasscode');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function schoolPassCode()
    {
        Log::info('[RegisterController.schoolPassCode] Start...');
        $parents = Auth::guard('parents')->user();
        if (isset($parents) && $parents->id > 0) {
            Log::info('[RegisterController.schoolPassCode] End...');
            return redirect()->route('front.mypage.index');
        }
        $passcode = '';
        $data = \Session::get('register');
        if (isset($data['schoolPasscode'])) {
            $passcode = $data['schoolPasscode'];
        }
        Log::info('[RegisterController.schoolPassCode] End...');
        return view('front.register.schoolPasscode')->with('passcode', $passcode);
    }

    public function postSchoolPassCode(Request $request)
    {
        Log::info('[RegisterController.postSchoolPassCode] Start...');
        // validate
        $request->validate([
            'schoolPasscode' => 'required|regex:/^(?=.*?[a-z]{1})(?=.*?[0-9]{4})/',
        ], [
            'required' => 'パスコードが必要です',
//            'size' => 'パスコードは5文字が含まれます',
            'regex' => 'パスコードには4桁の数字と1つの小文字が含まれます'
        ]);
        $request->validate([
            'school_check' => 'required',
        ], [
            'required' => 'チェックボックスが必要です'
        ]);

        //validate passcode is not exist or used
        $passCode = $this->schoolPasscode->getActivePasscode($request->get('schoolPasscode'));
        if (!$passCode) {
            Log::info('[RegisterController.postSchoolPassCode] End...');
            return redirect()->route('register.schoolpasscode')
                ->withErrors(['パスコードがアクティブではありません']);
        }
        //save data to Session
        \Session::put('register', $request->all());
        Log::info('[RegisterController.postSchoolPassCode] End...');

        return redirect()->route('register.passcode');
    }

    public function passCode(Request $request)
    {
        Log::info('[RegisterController.passCode] Start...');
        $passcode = '';
        $data = \Session::get('register');

        if (!$data) {
            Log::info('[RegisterController.passCode] End...');
            return redirect()->route('register.schoolpasscode');
        }

        $schoolName = $this->schoolPasscode->getSchoolName($data['schoolPasscode']);

        if (isset($data['schoolPasscode'])) {
            if (isset($data['passcode'])) {
                $passcode = $data['passcode'];
            }
            Log::info('[RegisterController.passCode] End...');
            return view('front.register.passcode')->with(['passcode' => $passcode, 'schoolName' => $schoolName]);
        } else {
            Log::info('[RegisterController.passCode] End...');
            return redirect()->route('register.schoolpasscode');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPassCode(Request $request)
    {
        Log::info('[RegisterController.postPassCode] Start...');
        // validate
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
            Log::info('[RegisterController.postPassCode] End...');
            return redirect()->route('register.passcode')
                ->withErrors(['パスコードが使用されているが存在しません']);
        }
        if (!$passCode->student) {
            Log::info('[RegisterController.postPassCode] End...');
            return redirect()->route('register.passcode')->withErrors(['パスコードはこの学生のものではありません']);
        }
        if (!$passCode->student->schoolClass) {
            Log::info('[RegisterController.postPassCode] End...');
            return redirect()->route('register.passcode')->withErrors(['学生はこのクラスのものではありません']);
        }
        if (!$passCode->student->schoolClass->school) {
            Log::info('[RegisterController.postPassCode] End...');
            return redirect()->route('register.passcode')->withErrors(['クラスはこの学校のものではありません']);
        }

        $data = \Session::get('register');
        $schoolId = $this->schoolPasscode->getSchoolByPasscode($passCode->student->school_id, $data['schoolPasscode']);
        if ($schoolId == 0) {
            Log::info('[RegisterController.index] End...');
            return redirect()->route('register.passcode')->withErrors(['学生はこの学校のものではありません']);
        }
        if ($data['schoolPasscode']) {
            $request->request->add(['schoolPasscode' => $data['schoolPasscode']]);
        }

        DB::transaction(function () use ($passCode, $request) {
            /*$parent = Auth::guard('parents')->user();
            $parent->student()->attach($passCode->student->id);
            $passCode->used = $passCode->used + 1;
            $passCode->save();*/
            // Comment for changed spec - no need to deactive
            //$passCode->used = $passCode->used + 1;
            PassCode::where('passcode', $request->get('passcode'))
                ->where('student_id', $passCode->student->id)
                ->update(['used' => $passCode->used]);
        });
        //save data to Session
        \Session::put('register', $request->all());
        Log::info('[RegisterController.postPassCode] End...');

        return redirect()->route('register.email');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function inputEmail()
    {
        Log::info('[RegisterController.inputEmail] Start...');
        $data = \Session::get('register');
        if (!isset($data['passcode'])) {
            Log::info('[RegisterController.inputEmail] End...');
            return redirect()->route('register.passcode');
        }
        Log::info('[RegisterController.inputEmail] End...');
        return view('front.register.inputEmail')->with(compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEmail(Request $request)
    {
        Log::info('[RegisterController.postEmail] Start...');
        // validate
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users|confirmed',
        ], [
            'required' => 'メールが必要です',
            'string' => 'メールは文字列です',
            'email' => 'メールが間違っています',
            'unique' => 'メールが存在します',
            'confirmed' => 'メールアドレス上記のものと違います。'
        ]);


        // save data to Session
        $data = \Session::get('register');
        $data['email'] = $request->get('email');

        $data['password'] = 'password';

        $passCode = $this->passCode->where('passcode', $data['passcode'])->first();
        if (!$passCode->student) {
            Log::info('[RegisterController.postEmail] End...');
            return redirect()->route('register.passcode')->withErrors(['パスコードはこの学生のものではありません']);
        }
        if (!$passCode->student->schoolClass) {
            Log::info('[RegisterController.postEmail] End...');
            return redirect()->route('register.passcode')->withErrors(['学生はこのクラスのものではありません']);
        }
        if (!$passCode->student->schoolClass->school) {
            Log::info('[RegisterController.postEmail] End...');
            return redirect()->route('register.passcode')->withErrors(['クラスはこの学校のものではありません']);
        }
        $school = $passCode->student->schoolClass->school;
        DB::transaction(function () use ($data, $passCode, $school) {
            $calendar = $this->calendar->create([
                'name' => $data['email'],
                'school_id' => $school->id,
                'event_bgcolor' => $this->eventBgcolor,
                'type' => 'user'
            ]);

            $customer = $this->customer->create([
                'name' => 'last name',
                'email' => $data['email'],
                'password' => $data['password'],
                'activate' => 1,
                'school_id' => $school->id,
                'calendar_id' => $calendar->id
            ]);
            $customer->student()->sync($passCode->student->id);

            $userSetting = new UserSetting();
            $userSetting->user_id = $customer->id;
            $userSetting->save();

            // Comment for changed spec - no need to deactive
            $passCode->used = $passCode->used + 1;
            $passCode->save();

            $customer->sendEmailVerificationNotification();
        });
        //TODO: first name and last name default

        \Session::put('register', []);
        Log::info('[RegisterController.postEmail] End...');
        return redirect()->route('verification.notice')->with('resent', true);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function inputPassword(Request $request, $id)
    {
        Log::info('[RegisterController.inputPassword] Start...');
        if (!$request->hasValidSignature()) {
            Log::info('[RegisterController.inputPassword] End...');
            return redirect()->route('customer.login');
        }
        $parents = $this->customer->find($request->id);


        if ($request->route('id') != $parents->getKey()) {
            throw new AuthorizationException;
        }
        Log::info('[RegisterController.inputPassword] End...');

        return view('front.register.inputPassword')->with('id', $id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPassword(Request $request)
    {
        Log::info('[RegisterController.postPassword] Start...');
        //validate
        $request->validate([
            'password' => 'required|max:20|min:8|confirmed|regex:/^[a-zA-Z0-9]+$/',
        ], [
            'required' => 'パスワードが必要です',
            'max' => 'パスワードは20文字以内が含まれます',
            'min' => 'パスワードは8文字以上が含まれます',
            'regex' => 'パスワードが間違っています',
            'confirmed' => 'パスワードが上記のものと違います。'
        ]);


        $parents = $this->customer->find($request->id);


        if (!$parents) {
            Log::info('[RegisterController.postPassword] End...');
            return redirect()->route('register.passcode');
        }

        $updatePasswordUser = $parents->update(['password' => Hash::make($request->password)]);

        if ($parents->markEmailAsVerified()) {
            event(new VerifyEmail($parents));
        }


        \Session::put('register', []);
        Log::info('[RegisterController.postPassword] End...');

        return redirect()->route('register.success');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        Log::info('[RegisterController.success] Start...');
//        event(new CompletedAccount('aaaaa'));
        return view('front.register.success');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showGuide()
    {
        Log::info('[RegisterController.showGuide] Start...');
        return view('front.register.faq');
    }

}
