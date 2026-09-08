<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Date;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        return view('reservation.create');
    }

    public function view(Request $request)
    {
        if (! $request->isMethod('POST')) {
            return view('reservation.view');
        }

        $validator = $request->validate([
            'email' => ['required', 'email', 'min:5'],
        ]);

        // $reservation_details = Reservation::select('*')->where('email', '=', $request->input('email'));
        $reservation_details = json_decode(json_encode(DB::select('select * from reservations where email = ? order by date desc, arrival desc limit 10', [$request->input('email')])), true);
        // dd($reservation_details);

        return view('reservation.view')->with('reserveringen', $reservation_details)->with('email', $request->input('email'));
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
            'arrival' => ['required', 'string', 'regex:((2[0-3]|[01][1-9]|10):([0-5][0-9]))'],
            // 'arrival' => ['required', 'between:1600,2200'], // Would work but I don't send an integer to the server. Would require extra javascript on the client.
        ],
            [
                'amount_of_people.max' => 'U kan niet via de form reserveren voor een groep van meer dan 10, bel het restaurant voor mogelijkheden',
            ]);

        $input = DateTime::createFromFormat('H:i', $request->input('arrival'));
        $min = DateTime::createFromFormat('H:i', '16:00');
        $max = DateTime::createFromFormat('H:i', '22:00');
        // dd([$input, $min, $max]);
        if ($input < $min || $input > $max) {
            return redirect('/reservation')->withErrors('De ingevoerde tijd is niet tussen 16:00 en 22:00');
        }
        $current_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->modify('+1 day')->format('Y-m-d'));
        $select_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d'));
        if ($current_date > $select_date) {
            return redirect('/reservation')->withErrors('Voor de ingevoerde datum kan je niet meer reserveren. Je moet ten minste 1 dag van te voren reserveren.');
        }
        // Does not work for some reason?
        // $future_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->modify('+60 days')->format('Y-m-d'));
        // if ($current_date > $future_date) {
        //     return redirect('/reservation')->withErrors('Voor de ingevoerde datum kan je nog niet reserveren. Je kan maximaal 60 dagen van te voren reserveren.');
        // }

        // Add seats check.
        $chairs_used = DB::select('select sum(amount_of_people) from reservations where date = ?;', [$request->input('date')]);
        // dd($chairs_used);
        $chairs_used = json_decode(json_encode($chairs_used), true)[0]['sum'];  // I couldn't find any other way to turn it into an integer.
        // dd($chairs_used);
        // dd($chairs_used + $request->input('amount_of_people'));
        // dd(Config::get('app.seats') - ($chairs_used + $request->input('amount_of_people')));
        // All this could've been avoidded if I ran:

        /*
         * php artisan config:clear
         * php artisan cache:clear
         */
        if (Config::get('app.seats') - ($chairs_used + $request->input('amount_of_people')) < 0) {
            // $tmp = $chairs_used - $request->input('amount_of_people');
            return redirect('/reservation')->withErrors('De reservering is niet gelukt, helaas hebben we deze dag geen stoelen meer!');
        }

        Reservation::fillAndInsert([
            'number' => generate_reservation_number(),
            'name' => $request->input('name'),
            'amount_of_people' => $request->input('amount_of_people'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'date' => $request->input('date'),
            'arrival' => $request->input('arrival'),
            'departure' => new DateTime($request->input('arrival'))->modify('+120 minutes'),
        ]);

        return redirect('/reservation')->with('success', 'De reservering is gelukt!');
    }
}
