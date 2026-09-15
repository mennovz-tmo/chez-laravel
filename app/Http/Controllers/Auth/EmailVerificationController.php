<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('welcome');
        }

        return view('auth.verify');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('welcome')->with('success', 'Je e-mailadres is geverifieerd!');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('welcome');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Er is een nieuwe verificatielink naar je e-mailadres gestuurd.');
    }
}
