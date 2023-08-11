<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AccountVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->email_verified_at) {
            // limit resend otp_code every 60 seconds
            // if (auth()->user()->otp_code && now()->diffInSeconds(auth()->user()->updated_at) < 60) {
            //     return redirect()->route('verification.notice');
            // }

            // send otp_code to user email
            // $otp_code = rand(100000, 999999);
            // auth()->user()->update([
            //     'otp_code' => $otp_code
            // ]);

            // $data = [
            //     'name' => auth()->user()->name,
            //     'email' => auth()->user()->email,
            //     'otp_code' => $otp_code,
            // ];

            // Mail::send('emails.verify-account-mail', $data, function ($message) {
            //     $message->from(config('mail.from.address'), config('mail.from.name'));
            //     $message->sender(config('mail.from.address'), config('mail.from.name'));
            //     $message->to(auth()->user()->email, auth()->user()->name);
            //     $message->subject('OTP Code for Verification');
            // });

            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
