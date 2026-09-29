<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Email verified successfully! Welcome to Fan Hub Plus.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent! Please check your email.');
    }
}
