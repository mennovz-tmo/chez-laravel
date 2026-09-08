<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function signup()
    {
        return view('admin.auth.signup');
    }
}
