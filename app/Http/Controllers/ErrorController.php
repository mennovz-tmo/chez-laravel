<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{
    public static function handleError(string $redirect = '/', array $messages = ['Een is iets fout gegaan, probeer het later opnieuw.'])
    {
        return redirect($redirect)->withErrors($messages);
    }
}
