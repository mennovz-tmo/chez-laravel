<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('reservation.create');
    }

    public function create(Request $request)
    {
        // dd($request->input('date'));
        $validator = $request->validate([
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'amount_of_people' => ['required', 'numeric', 'min:1', 'max:10'],
            'phone_number' => ['required', 'phone_number', 'min:10', 'max:11'],
            'email' => ['required', 'email'],
            'comment' => ['nullable', 'string', 'max:1024'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'arrival' => ['required', 'regex:((2[0-3]|[01][1-9]|10):([0-5][0-9]))'],
        ],
            [
                'amount_of_people.max' => 'U kan niet via de form reserveren voor een groep van meer dan 10, bel het restaurant voor mogelijkheden',
            ]);

        $input = DateTime::createFromFormat('H:i', $request->input('arrival'));
        $min = DateTime::createFromFormat('H:i', '16:00');
        $max = DateTime::createFromFormat('H:i', '22:00');
        // dd([$input, $min, $max]);
        if ($input < $min && $input > $max) {
            return redirect('/reservation')->withErrors('De ingevoerde tijd is niet tussen 16:00 en 22:00');
        }

        return redirect('/reservation')->with('success', 'De reservering is gelukt!');
    }
}
