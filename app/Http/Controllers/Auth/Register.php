<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (!Config::get('auth.account_creation_enabled')) {
            return redirect('/')->withErrors('Het maken van accounts is uitgezet door de website beheerder.');
        }

        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:12|confirmed',
        ]);

        $hasOwner = User::where('role', 'owner')->exists();
        if (! $hasOwner) {
            $user = User::create([
                'name' => $validator['name'],
                'email' => $validator['email'],
                'password' => Hash::make($validator['password']),
            ]);
            $user->update(['role' => 'owner']);
        } else {
            $user = User::create([
                'name' => $validator['name'],
                'email' => $validator['email'],
                'password' => Hash::make($validator['password']),
            ]);
        }

        Auth::login($user);

        return redirect('/')->with('success', 'hej! Account created!');
    }
}
