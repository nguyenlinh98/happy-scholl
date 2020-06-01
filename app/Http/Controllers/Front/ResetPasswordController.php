<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Parents;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;


class ResetPasswordController extends Controller
{

    public function forgetPassword()
    {
        Log::info('[ResetPasswordController.forgetPassword] Start...');
        return view('front.auth.forgetpassword');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMail(Request $request)
    {
        Log::info('[ResetPasswordController.sendMail] Start...');
        $user = Parents::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors('ご入力いただいたメールアドレスが存在しません。');
        }
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ]);
        if ($passwordReset) {
            $user->notify(new ResetPasswordRequest($passwordReset->token));
        }
        Log::info('[ResetPasswordController.sendMail] End...');

        return view('front.auth.confirm-reset-password');
    }

    public function inputPassword($token)
    {
        Log::info('[ResetPasswordController.inputPassword] Start...');
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            Log::info('[ResetPasswordController.inputPassword] End...');
            return redirect()->route('customer.login')->withErrors('This password reset token is invalid.');
        }
        Log::info('[ResetPasswordController.inputPassword] End...');
        return view('front.auth.input-password')->with('token', $token);
    }

    public function reset(Request $request, $token)
    {
        Log::info('[ResetPasswordController.reset] Start...');
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            Log::info('[ResetPasswordController.reset] End...');
            return redirect()->route('customer.login')->withErrors('This password reset token is invalid.');
        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            Log::info('[ResetPasswordController.reset] End...');
            return redirect()->route('customer.change-password')->withErrors('This password reset token is invalid.');
        }
        $user = Parents::where('email', $passwordReset->email)->firstOrFail();
        $updatePasswordUser = $user->update(['password' => Hash::make($request->password)]);
        $passwordReset->delete();
        Log::info('[ResetPasswordController.reset] End...');

        return redirect()->route('customer.login');
    }
}
