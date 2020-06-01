<?php

namespace App\Http\Controllers\TopAdmin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TopAdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/top_admin/school';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest:topadmin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('top_admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('topadmin');
    }

    public function logout(Request $request)
    {
        Auth::guard('topadmin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
 
        return redirect('/top_admin/login');
    }

}
