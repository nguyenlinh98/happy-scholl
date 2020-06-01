<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class TeacherLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/urgency/top';

    /**
     * CustomerLoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest:teacher')->except('logout');
    }

    public function username()
    {
        return 'school_login_id';
    }

    // login from for teacher
    public function showLoginForm()
    {
        return view('front.auth.login-teacher');
    }

   /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('teacher');
    }

}
