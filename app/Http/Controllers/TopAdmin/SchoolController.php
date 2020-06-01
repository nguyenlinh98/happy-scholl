<?php

namespace App\Http\Controllers\TopAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\SchoolRequest;
use App\Http\Requests\School\TopAdminRequest;
use App\Models\Calendar;
use App\Models\Event;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\SchoolPasscode;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ResetsPasswords;
use MongoDB\Driver\Session;
use URL;
use Log;
use DB;

class SchoolController extends Controller
{
    use ResetsPasswords;
    private $school;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(School $school)
    {
        $this->middleware('auth:topadmin');
        $this->school = $school;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('[SchoolController.index] Start...');
        $schools = School::all();

        Log::info('[SchoolController.index] End...');
        return view('top_admin.school.index', ['schools' => $schools]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('[SchoolController.create] Start...');

        $school = new School();
        $school->prepare();

        Log::info('[SchoolController.create] End...');
        return view('top_admin.school.create', ['school' => $school]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createConfirm(SchoolRequest $request)
    {
        Log::info('[SchoolController.create_confirm] Start...');
        $school = new School();
        $school->fill($request->all());
        $school->domain = URL::to('/').'/admin';
        $school->issue_date = Carbon::now()->format('Y/m/d');

        $request->session()->put('school', $school);

        Log::info('[SchoolController.create_confirm] End...');
        return view('top_admin.school.create_confirm', ['school' => $school]);
    }

    function createSchoolPasscode() {
        // 変数の初期化
        $res = ''; //生成した文字列を格納

        // one lower letter
        $lower_letter_base_strings = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $res .= $lower_letter_base_strings[mt_rand( 0, count($lower_letter_base_strings)-1)];

        $number_string_length = 4; //生成する文字列の長さを指定

        for( $i=0; $i<$number_string_length; $i++ ) {
            $res .= mt_rand( 0, 9);
        }

        return $res;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolRequest $request)
    {
        if($request-> filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('top_admin.school.create')->withInput();
        }
        Log::info('[SchoolController.store] Start...');
        DB::beginTransaction();
        try {
            // Add school
            $school = new School();
            $school->fill($request->all());
            // $school->calendar_id = $calendar->id;
            $school->save();

            // prepare for create login user
            $passcode = $this->createSchoolPasscode();
            $password = str_random(8);
            $email = $passcode . '@mail.'.$request->getHost();

            // Create Schooll passcode
            $schoolPass = new SchoolPasscode();
            $schoolPass->passcode = $passcode;
            $schoolPass->school_id = $school->id;
            $schoolPass->save();

            // create login info
            SchoolAdmin::create([
                'name' => $email,
                'school_login_id' => $passcode,
                'email' => $email,
                'password' => Hash::make($password),
                'school_id' => $school->id,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('message', 'エラーが発生しました。');
            return view('top_admin.school.create_confirm', ['school' => $school]);
        }
        // DB::transaction(function () use ($request) {
        //     // Add default calendar for school
        //     // $calendar = new Calendar();
        //     // $calendar->name = $request->name;
        //     // $calendar->save();

            

        //     //session()->flash('message', 'login info:passcode:' . $passcode . ' password:'.$password);
        //     $schoolId = $school->id;

        //     $schoolPassCode = SchoolPasscode::query()->where("passcode", "=", $passcode)->first();
        //     Log::info('[SchoolController.store] End...');

        //     // return redirect()->route('top_admin.school.detail',$_SESSION['school_id'])->with(['schoolPasscode' => $schoolPassCode, 'password' => $password]);
        // });

        Log::info('[SchoolController.store] End...');
        return view('top_admin.school.detail', ['school' => $school, 'schoolPasscode' => $schoolPass, 'password' => $password]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = $this->school->findorfail($id);
        $schoolPassCode = SchoolPasscode::query()->where("school_id", "=", $id)->first();
        return view('top_admin.school.edit', ['school' => $school, 'schoolPasscode' => $schoolPassCode]);
    }

    public function editConfirm(SchoolRequest $request, School $school){
        Log::info('[SchoolController.editConfirm] Start...');
        if($request-> filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('top_admin.school.edit')->withInput();
        }
        Log::info('[SchoolController.editConfirm] Start...');
        $school->fill($request->all());

        Log::info('[SchoolController.editConfirm] End...');
        return view('top_admin.school.edit_confirm', ['school' => $school]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolRequest $request, School $school)
    {
        if($request-> filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('top_admin.school.edit',$school)->withInput();
        }
        $school->fill($request->all());
        $school->save();

        session()->flash('message', __('school.action.updated'));

        return redirect()->route('top_admin.school.detail',$school);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::info('[SchoolController.destroy] Start...');
        School::find($request->id)->delete();
        // dd($request->id);
        // $school->delete();

        session()->flash('message', __('school.action.deleted'));

        Log::info('[SchoolController.destroy] Delete...');
        return redirect()->route('top_admin.school.index');
    }

    /**
     * 
     */
    public function detail(Request $request, $id){
        $school = $this->school->findorfail($id);
        $schoolPassCode = SchoolPasscode::query()->where("school_id", "=", $id)->first();
        return view('top_admin.school.detail', ['school' => $school, 'schoolPasscode' => $schoolPassCode]);
    }

    /**
     * 
     */
    public function updateSchoolCode($id)
    {
        Log::info('[SchoolController.updateSchoolCode] Start...');
        $school = $this->school->findorfail($id);
        $schoolPasscode = SchoolPasscode::query()->where("school_id", "=", $id)->first();

        $schoolAdmin = SchoolAdmin::where('school_id', $id)->where('school_login_id', $schoolPasscode->passcode)->firstOrFail();
        // Make new Password
        $password = str_random(8);
        $schoolAdmin->password = Hash::make($password);
        $schoolAdmin->save();

        session()->flash('message', __('school.action.resetPassword'));
        Log::info('[SchoolController.updateSchoolCode] End...');
        return view('top_admin.school.detail', ['school' => $school, 'schoolPasscode' => $schoolPasscode, "password" => $password]);
    }
}
