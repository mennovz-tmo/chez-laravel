<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Models\User;

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

    public function store(UserEditRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()
            ->route('manage.users.view')
            ->with('success', 'Het account is aangepast.');
    }

    public function delete(User $user)
    {
        if ($user->role == 'owner') {
            return redirect()->route('manage.users.view')
                ->with('error', 'Dit account kan niet worden verwijderd omdat het een super admin is.');
        }

        $user->delete();

        return redirect()->route('manage.users.view')
            ->with('success', 'De gebruiker is permanent verwijderd');
    }
}
