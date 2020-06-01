<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;

class LoginController extends Controller
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
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getApiToken() {
        $email = request()->get("email");
        $password = request()->get("password");
        // Check validation
        if (auth()->attempt(['email' => $email, 'password' => $password])) {
            $user = \App\Models\User::where("email",$email)->first();
            return response()->json([
                "data" => $user
            ],200);
        } else {
            return response()->json(['message'=>'unauthenticated'],401);
        }
    }
}
