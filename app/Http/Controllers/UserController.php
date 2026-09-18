<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use function in_array;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function index()
    {
        $users = User::where('role', '!=', 'owner')
            ->get()
            ->sortDesc();

        return view('manage.users.view')->with('users', $users);
    }

    public function edit(User $user)
    {
        return view('manage.users.edit', compact('user'))
            ->with('user', $user);
    }

    public function edit_store(Request $request, User $user)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required|string',
        ]);

        $new_email = User::select('id', 'email')->where('email', '=', $validator['email'])->get()->toArray();
        if (! empty($new_email)) {
            if ($user->id != $new_email[0]['id']) {
                return redirect()
                    ->route('manage.users.edit', compact('user'))
                    ->withErrors('Het email dat is ingevuld wordt al gebruikt door een andere gebruiker.');
            }
        }

        if (! in_array($validator['role'], ['staff', 'consumer'])) {
            return redirect()
                ->route('manage.users.edit', compact('user'))
                ->withErrors('De ingevoerde rol is ongeldig en kan alleen \'staff\' of \'gebruiker\' zijn');
        }

        $user->update([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'role' => $validator['role'],
        ]);

        return redirect()
            ->route('manage.users.view')
            ->with('success', 'Het account is aangepast.');
    }

    public function delete(User $user)
    {
        $user->delete();

        return redirect()->route('manage.users.view')
            ->with('success', 'De gebruiker is permanent verwijderd');
    }
}
