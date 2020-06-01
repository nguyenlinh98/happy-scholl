<?php
/**
 * User: JohnAVu
 * Date: 2020-01-10
 * Time: 10:25
 */

namespace App\Traits\Models;

use App\Models\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;


trait   VerifiesEmails
{
    use RedirectsUsers;

    protected $guard = 'parents';

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(!$request->user($this->guard)){
            return view('front.auth.verify');
        }
        return $request->user($this->guard)->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('front.auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request, $id)
    {
//        dd($request->all());
        if (!$request->hasValidSignature()) {
            return redirect()->route('customer.login');
        }

        /*$user = $request->user($this->guard);
        if (!$user) {
            $user = User::find($id);
        }*/
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('customer.login');
        }

        if ($user->password == 'password') {
            $url =  URL::temporarySignedRoute(
                'register.password',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                ['id' => $user->id]
            );
            return redirect($url);
            return redirect()->route('register.password',[$user->id,'expires'=>$request->expires,'signature'=>$request->signature]);
        }

        if ($request->route('id') != $user->getKey()) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user($this->guard)->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user($this->guard)->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}