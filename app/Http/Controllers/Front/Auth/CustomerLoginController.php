<?php
/**
 * User: JohnAVu
 * Date: 2019-12-18
 * Time: 14:16
 */

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/front/regist-device-token';

    /**
     * CustomerLoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest:parents')->except('logout');
    }

    /**
     * @return mixed
     */
    public function guard()
    {
        return Auth::guard('parents');
    }

    // login from for teacher
    public function showLoginForm()
    {
        Log::info('[CustomerLoginController.showLoginForm] Start...');
        return view('front.auth.login');
    }
}
