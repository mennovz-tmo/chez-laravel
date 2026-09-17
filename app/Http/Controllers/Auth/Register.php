<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:12|confirmed',
        ]);

        $user = User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => Hash::make($validator['password']),
        ]);

        if (!User::where('role', 'owner')->exists()) {
            $user->update(['role' => 'owner']);
        }

        $user->sendEmailVerificationNotification();

        return redirect()
            ->route('login')
            ->with('success', 'Account aangemaakt! Controleer je e-mail en klik op de link om je e-mailadres te bevestigen.');
    }
}
