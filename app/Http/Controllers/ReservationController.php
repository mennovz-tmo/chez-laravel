<?php

namespace App\Http\Controllers;

use App\Mail\ReservationCreated;
use App\Mail\ReservationDeleteRequested;
use App\Models\OpeningDatetime;
use App\Models\Reservation;
use App\Models\WeeklySchedule;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelPdf\Facades\Pdf;

use function in_array;

class ReservationController extends Controller
{
    public function delete(Request $request, Reservation $reservation, ?string $delete_token = null)
    {
        if ($reservation == null) {
            return redirect()
                ->route('reservation.view')
                ->withErrors('De reservering die verwijderd zou worden bestaat niet!')
                ->withInput();
        }

        if (Auth::check() && isStaff()) {
            $reservation->delete();

            return redirect()
                ->route('reservation.view')
                ->with('success', 'De reservering is verwijderd');
        }

        if (! $this->isDeletionAllowed($reservation)) {
            return redirect()
                ->route('reservation.view')
                ->withErrors('De reservering die verwijderd zou worden kan niet meer verwijderd worden omdat het minder dan 12 uur voor de reservering is! Bel om de annulering te overleggen')
                ->withInput();
        }

        if (Auth::check() && Auth::user()->hasVerifiedEmail() && Auth::user()->email === $reservation->email) {
            $reservation->delete();

            return redirect()
                ->route('reservation.view')
                ->with('success', 'De reservering is verwijderd');
        }

        if ($delete_token == null) {
            $plainToken = $reservation->generateDeleteToken();

            Mail::to($reservation->email)
                ->send(new ReservationDeleteRequested($reservation, $plainToken));

            return view('reservation.delete')
                ->with('reservation', $reservation);
        }

        if ($reservation->delete_token_expires_at !== null && $reservation->delete_token_expires_at->isPast()) {
            $reservation->clearDeleteToken();

            return redirect()
                ->route('reservation.view')
                ->withErrors('De link om te verwijderen is verlopen! Vraag opnieuw een verwijdering aan om een nieuwe link te krijgen.')
                ->withInput();
        }

        if (! $reservation->hasValidDeleteToken($delete_token)) {
            return redirect()
                ->route('reservation.view')
                ->withErrors('Deze link om een reservering te verwijderen is niet geldig!')
                ->withInput();
        }

        $reservation->delete();

        return redirect()
            ->route('reservation.view')
            ->with('success', 'De reservering is verwijderd');
    }

    /**
     * A guest may only delete up to 12 hours before the reservation.
     */
    private function isDeletionAllowed(Reservation $reservation): bool
    {
        $datetime_of_reservation = new DateTime("{$reservation->date->format('Y-m-d')} {$reservation->arrival}");

        return $datetime_of_reservation > now()->addHours(12);
    }

    public function index()
    {
        $weekly_times = WeeklySchedule::select('opening', 'closing')
            ->where('day_of_week', '=', 2)
            ->get()[0];

        return view('reservation.create')
            ->with('weekly_opening_time', $weekly_times['opening']->format('H:i'))
            ->with('weekly_closing_time', $weekly_times['closing']->format('H:i'));
    }

    public function show(Reservation $reservation)
    {
        return view('reservation.show', compact('reservation'));
    }

    public function view(Request $request)
    {
        $query = Reservation::query();

        if (Auth::check() && $request->input('email') == null && isStaff() && $request->input('start') == null && $request->input('end') == null && $request->input('name') == null) {
            return view('reservation.view')
                ->with('reservations', $query
                    ->orderByDesc('date')
                    ->orderByDesc('arrival')
                    ->get());
        }

        $method = $request->getMethod();
        if (in_array($method, ['POST', 'GET']) && ($request->filled('start') || $request->filled('end') || $request->filled('name') || $request->filled('email'))) {
            $validated = $request->validate([
                'start' => ['nullable', 'date', 'date_format:Y-m-d'],
                'end' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:start'],
                'email' => ['nullable', 'email', 'min:5'],
                'name' => ['nullable', 'string', 'min:1', 'max:255'],
            ], [
                'end.after_or_equal' => 'De einddatum moet gelijk zijn aan of na de startdatum.',
            ]);

            if (! Auth::check() && ! $request->filled('name') && ! $request->filled('email')) {
                return redirect()
                    ->route('reservation.view')
                    ->withErrors('Je moet zoeken met email of exacte naam als gast!')
                    ->withInput();
            }

            if ($request->filled('start') && $request->filled('end')) {
                $query->whereBetween('date', [$validated['start'], $validated['end']]);
            } elseif ($request->filled('start')) {
                $query->where('date', $validated['start']);
            }

            if ($request->filled('name')) {
                if (Auth::check()) {
                    $query->where('name', 'like', '%'.$validated['name'].'%');
                } else {
                    $query->where('name', '=', $validated['name']);
                }
            }

            if ($request->filled('email')) {
                $query->where('email', $validated['email']);
            }

            $reservations = $query
                ->orderByDesc('date')
                ->orderByDesc('arrival')
                ->get();

            return view('reservation.view')
                ->with('reservations', $reservations)
                ->with('email', $request->input('email'))
                ->with('name', $request->input('name'))
                ->with('start', $request->input('start'))
                ->with('end', $request->input('end'));
        }

        return view('reservation.view');
    }

    public function create(Request $request)
    {
        $validator = $request->validate([
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'amount_of_people' => ['required', 'numeric', 'min:1', 'max:10'],
            'phone_number' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'comment' => ['nullable', 'string', 'max:1024'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'arrival' => ['required', 'string', 'regex:((2[0-3]|[01][1-9]|10):([0-5][0-9]))'],
        ],
            [
                'amount_of_people.max' => 'U kan niet via de form reserveren voor een groep van meer dan 10, bel het restaurant voor mogelijkheden',
            ]);

        $opening_datetime = OpeningDatetime::select(['open', 'opening', 'closing'])
            ->where('date', '=', $request->input('date'))
            ->limit(1)
            ->get();
        if ($opening_datetime->count() > 0) {
            $opening_datetime = $opening_datetime[0];
            if (! $opening_datetime['open']) {
                return redirect()
                    ->route('reservation.create')
                    ->withErrors('De ingevoerde datum zijn wij helaas gesloten.')
                    ->withInput();
            }
            $opening_dt = new DateTime($opening_datetime['opening']);
            $closing_dt = new DateTime($opening_datetime['closing']);
            $requested_dt = DateTime::createFromFormat('H:i', $request->input('arrival'));
            if ($requested_dt < $opening_dt || $requested_dt > $closing_dt) {
                return redirect()
                    ->route('reservation.create')
                    ->withErrors("De ingevoerde tijd ligt niet tussen onze speciale openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}.")
                    ->withInput();
            }
        }
        $requested_day = new DateTime($request->input('date'))->format('N') - 1;
        $default_schedule = WeeklySchedule::select('is_open', 'opening', 'closing')
            ->where('day_of_week', '=', $requested_day)
            ->limit(1)
            ->get();
        if ($default_schedule->count() > 0) {
            $default_schedule = $default_schedule[0];
            if (! $default_schedule['is_open']) {
                return redirect()
                    ->route('reservation.create')
                    ->withErrors('De ingevoerde datum zijn wij helaas gesloten.')
                    ->withInput();
            }
            $opening_dt = new DateTime($default_schedule['opening']);
            $closing_dt = new DateTime($default_schedule['closing']);
            $requested_dt = DateTime::createFromFormat('H:i', $request->input('arrival'));
            if ($requested_dt < $opening_dt || $requested_dt > $closing_dt) {
                return redirect()
                    ->route('reservation.create')
                    ->withErrors("De ingevoerde tijd ligt niet tussen onze openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}.")
                    ->withInput();
            }
        }

        $current_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->modify('+1 day')->format('Y-m-d'));
        $future_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->modify('+61 day')->format('Y-m-d'));
        $select_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d'));
        if ($current_date > $select_date) {
            return redirect()
                ->route('reservation.create')
                ->withErrors('Voor de ingevoerde datum kan je niet meer reserveren. Je moet ten minste 1 dag van te voren reserveren.')
                ->withInput();
        }
        if ($future_date < $select_date) {
            return redirect()
                ->route('reservation.create')
                ->withErrors('Voor de ingevoerde datum kan je nog niet reserveren. Je kan maximaal 60 dagen van te voren reserveren.')
                ->withInput();
        }

        $chairs_used = Reservation::where('date', '=', $request->input('date'))->sum('amount_of_people');
        if (Config::get('app.seats') - ($chairs_used + $request->input('amount_of_people')) < 0) {
            // $tmp = $chairs_used - $request->input('amount_of_people');
            return redirect()
                ->route('reservation.create')
                ->withErrors('De reservering is niet gelukt, helaas hebben we deze dag geen stoelen meer!')
                ->withInput();
        }

        $reservation = Reservation::create([
            'name' => $request->input('name'),
            'amount_of_people' => $request->input('amount_of_people'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'date' => $request->input('date'),
            'arrival' => $request->input('arrival'),
            'departure' => new DateTime($request->input('arrival'))->modify('+120 minutes'),
        ]);

        Mail::to($reservation->email)->send(new ReservationCreated($reservation));

        return redirect()
            ->route('reservation.create')
            ->with('success', 'De reservering is gelukt! U krijgt een email met de details.');
    }

    public function edit(Request $request, Reservation $reservation)
    {
        if ($request->isMethod('GET')) {
            return view('reservation.edit')
                ->with('current_data', $reservation);
        }

        $validator = $request->validate([
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'amount_of_people' => ['required', 'numeric', 'min:1', 'max:10'],
            'phone_number' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'comment' => ['nullable', 'string', 'max:1024'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'arrival' => ['required', 'string', 'regex:((2[0-3]|[01][1-9]|10):([0-5][0-9]))'],
        ],
            [
                'amount_of_people.max' => 'U kan niet via de form reserveren voor een groep van meer dan 10, bel het restaurant voor mogelijkheden',
            ]);

        $opening_datetime = OpeningDatetime::select(['open', 'opening', 'closing'])
            ->where('date', '=', $request->input('date'))
            ->limit(1)
            ->get();
        if ($opening_datetime->count() > 0) {
            $opening_datetime = $opening_datetime[0];
            if (! $opening_datetime['open']) {
                return redirect()
                    ->route('reservation.edit', compact('reservation'))
                    ->withErrors('De aanpassing is niet gelukt, de nieuwe datum zijn wij helaas gesloten.')
                    ->withInput();
            }
            $opening_dt = new DateTime($opening_datetime['opening']);
            $closing_dt = new DateTime($opening_datetime['closing']);
            $requested_dt = DateTime::createFromFormat('H:i', $request->input('arrival'));
            if ($requested_dt < $opening_dt || $requested_dt > $closing_dt) {
                return redirect()
                    ->route('reservation.edit', compact('reservation'))
                    ->withErrors("De nieuwe tijd ligt niet tussen onze speciale openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}.")
                    ->withInput();
            }
        }
        $requested_day = new DateTime($request->input('date'))->format('N') - 1;
        $default_schedule = WeeklySchedule::select('is_open', 'opening', 'closing')
            ->where('day_of_week', '=', $requested_day)
            ->limit(1)
            ->get();
        if ($default_schedule->count() > 0) {
            $default_schedule = $default_schedule[0];
            if (! $default_schedule['is_open']) {
                return redirect()
                    ->route('reservation.edit', compact('reservation'))
                    ->withErrors('De aanpassing is niet gelukt, de nieuwe datum zijn wij helaas gesloten.')
                    ->withInput();
            }
            $opening_dt = new DateTime($default_schedule['opening']);
            $closing_dt = new DateTime($default_schedule['closing']);
            $requested_dt = DateTime::createFromFormat('H:i', $request->input('arrival'));
            if ($requested_dt < $opening_dt || $requested_dt > $closing_dt) {
                return redirect()
                    ->route('reservation.edit', compact('reservation'))
                    ->withErrors("De nieuwe tijd ligt niet tussen onze openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}.")
                    ->withInput();
            }
        }

        $current_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->modify('+24 hours')->format('Y-m-d'));
        $future_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->modify('+61 day')->format('Y-m-d'));
        $select_date = new DateTime()->createFromFormat('Y-m-d', new DateTime()->createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d'));
        if ($current_date > $select_date) {
            return redirect()
                ->route('reservation.edit', compact('reservation'))
                ->withErrors('Voor de ingevoerde datum kan je niet meer je reservering aanpassen. Je moet ten minste 1 dag van te voren aanpassingen maken.')
                ->withInput();
        }
        if ($future_date < $select_date) {
            return redirect()
                ->route('reservation.edit', compact('reservation'))
                ->withErrors('Voor de ingevoerde datum kan je de reservering nog niet reserveren. Je kan maximaal 60 dagen van te voren reserveren.')
                ->withInput();
        }

        $chairs_used = Reservation::where('date', '=', $reservation->date)->where('id', '!=', $reservation->id)->sum('amount_of_people') ?? 0;
        if (Config::get('app.seats') - ($chairs_used + $request->input('amount_of_people')) < 0) {
            return redirect()
                ->route('reservation.edit', compact('reservation'))
                ->withErrors('De aanpassing is niet gelukt, helaas hebben we niet genoeg stoelen voor de aanpassing!')
                ->withInput();
        }

        $reservation->update([
            'name' => $request->input('name'),
            'amount_of_people' => $request->input('amount_of_people'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'date' => $request->input('date'),
            'arrival' => $request->input('arrival'),
            'departure' => new DateTime($request->input('arrival'))->modify('+120 minutes'),
        ]);

        Mail::to($reservation->email)->send(new ReservationCreated($reservation));

        return redirect()
            ->route('reservation.show', compact('reservation'))
            ->with('success', 'De reservering is aangepast! U krijgt een email met de nieuwe details.');
    }

    public function pdf(Reservation $reservation)
    {
        return Pdf::view('pdf.reservation', compact('reservation'))
            ->format('a4')
            ->margins(20, 15, 20, 15)
            ->name("reservation_$reservation->number.pdf")
            ->download();
    }
}
