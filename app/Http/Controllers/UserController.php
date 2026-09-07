<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    public function login() {
        return view('admin.auth.login');
    }

    public function signup()
    {
        return view('admin.auth.signup');
    }
}
