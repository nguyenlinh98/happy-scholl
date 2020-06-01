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

class TopAdminSettingController extends Controller
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

    public function changePassword()
    {
        return view('top_admin.setting.index');
    }

    public function resetPassword(Request $request)
    {
        Log::info('[TopAdminSettingController.resetPassword] Start...');
        $user = Auth::user();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'new_email' => 'required|email',
                'password' => 'required',
                'email_confirm' => 'required|same:new_email',
                'new_password' => 'required|min:8',
                'password_confirmation' => 'required|same:new_password',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $user->email = $request->new_email;
            $user->password = Hash::make($request->new_password);
            $user->save();
            session()->flash('action', 'updated');
            Log::info('[TopAdminSettingController.resetPassword] End...');
            // If the password was successfully reset, we will redirect the user back to
            // the application's home authenticated view. If there is an error we can
            // redirect them back to where they came from with their error message.
            return view('top_admin.setting.index');
        } else {
            return redirect()->back()->withInput();
        }
    }
}
