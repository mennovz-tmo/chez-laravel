<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationCreateRequest;
use App\Http\Requests\ReservationEditRequest;
use App\Mail\ReservationCreated;
use App\Mail\ReservationDeleteRequested;
use App\Models\Reservation;
use App\Models\WeeklySchedule;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelPdf\Facades\Pdf;

use function count;

class ReservationController extends Controller
{
    public function delete(Request $request, Reservation $reservation, ?string $delete_token = null)
    {
        if (Auth::check() && is_staff()) {
            $reservation->delete();

            return redirect()
                ->route('reservation.view')
                ->with('success', 'De reservering is verwijderd');
        }

        if (! $this->is_reservation_deletion_allowed($reservation)) {
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
            $plainToken = $reservation->generate_delete_token();

            Mail::to($reservation->email)
                ->send(new ReservationDeleteRequested($reservation, $plainToken));

            return view('reservation.delete')
                ->with('reservation', $reservation);
        }

        if ($reservation->delete_token_expires_at !== null && $reservation->delete_token_expires_at->isPast()) {
            $reservation->clear_delete_token();

            return redirect()
                ->route('reservation.view')
                ->withErrors('De link om te verwijderen is verlopen! Vraag opnieuw een verwijdering aan om een nieuwe link te krijgen.')
                ->withInput();
        }

        if (! $reservation->has_valid_delete_token($delete_token)) {
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

    private function is_reservation_deletion_allowed(Reservation $reservation): bool
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

    private function is_any_input_filled(Request $request, array $fields): bool
    {
        for ($i = 0; $i < count($fields); $i++) {
            if ($request->filled($fields[$i])) {
                return true;
            }
        }

        return false;
    }

    private function are_all_inputs_filled(Request $request, array $fields): bool
    {
        for ($i = 0; $i < count($fields); $i++) {
            if (! $request->filled($fields[$i])) {
                return false;
            }
        }

        return true;
    }

    public function view(Request $request)
    {
        $query = Reservation::query();

        if (Auth::check() && is_staff() && ! $this->is_any_input_filled($request, ['email', 'end', 'start', 'name'])) {
            return view('reservation.view')
                ->with('reservations', $query
                    ->orderByDesc('date')
                    ->orderByDesc('arrival')
                    ->get());
        }

        if (Auth::check() && ! is_staff() && ! $this->is_any_input_filled($request, ['email', 'end', 'start', 'name'])) {
            return view('reservation.view')
                ->with('reservations', $query
                    ->where('email', '=', Auth::user()->email)
                    ->orderByDesc('date')
                    ->orderByDesc('arrival')
                    ->get());
        }

        $validated = $request->validate([
            'start' => ['nullable', 'date', 'date_format:Y-m-d'],
            'end' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:start'],
            'email' => ['nullable', 'email', 'min:5'],
            'name' => ['nullable', 'string', 'min:1', 'max:255'],
        ], [
            'end.after_or_equal' => 'De einddatum moet gelijk zijn aan of na de startdatum.',
        ]);

        if (! Auth::check() && ! $this->is_any_input_filled($request, ['name', 'email', 'start', 'end'])) {
            return view('reservation.view');
        }

        if (! Auth::check() && ! $this->is_any_input_filled($request, ['name', 'email'])) {
            return redirect()
                ->route('reservation.view')
                ->withErrors('Je moet zoeken met email of exacte naam als gast!')
                ->withInput();
        }

        if ($this->are_all_inputs_filled($request, ['start', 'end'])) {
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

    private function reservation_attributes(array $validated): array
    {
        return [
            'name' => $validated['name'],
            'amount_of_people' => $validated['amount_of_people'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'comment' => $validated['comment'] ?? null,
            'date' => $validated['date'],
            'arrival' => $validated['arrival'],
            'departure' => (new DateTime($validated['arrival']))->modify('+120 minutes'),
        ];
    }

    public function create(ReservationCreateRequest $request)
    {
        $reservation = Reservation::create($this->reservation_attributes($request->validated()));

        Mail::to($reservation->email)->send(new ReservationCreated($reservation));

        return redirect()
            ->route('reservation.create')
            ->with('success', 'De reservering is gelukt! U krijgt een email met de details.');
    }

    public function edit(ReservationEditRequest $request, Reservation $reservation)
    {
        if ($request->isMethod('GET')) {
            return view('reservation.edit')
                ->with('current_data', $reservation);
        }

        $reservation->update($this->reservation_attributes($request->validated()));

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
