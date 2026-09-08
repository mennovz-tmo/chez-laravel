<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('reservation.create');
    }

    public function create(Request $request)
    {
        // FIXME: actual logic?? hello!
        $validator = $request->validate([
            'name' => ['bail', 'required', 'min:3', 'max:255'],
            'description_short' => ['required', 'min:16', 'max:1023'],
            'allergens' => ['required', 'string', 'min:3'],
            'price' => ['required', 'decimal:2', 'min:0.01'],
            // 'picture' => ['required', '', 'min:3']
            // ^^^ My brain I thought it was already a string ready for saving here. :) LOL.
            'picture' => ['required', 'image'],
        ]);

        return redirect('/');
    }
}
