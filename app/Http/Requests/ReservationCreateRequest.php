<?php

namespace App\Http\Requests;

use App\Models\OpeningDatetime;
use App\Models\Reservation;
use App\Models\WeeklySchedule;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class ReservationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'amount_of_people' => ['required', 'numeric', 'min:1', 'max:10'],
            'phone_number' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'comment' => ['nullable', 'string', 'max:1024'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'arrival' => ['required', 'string', 'regex:((2[0-3]|[01][1-9]|10):([0-5][0-9]))'],
        ];
    }

    /**
     * Run the database-backed checks once the base rules pass.
     *
     * @return array<int, callable>
     */
    protected function after(): array
    {
        return [
            function (Validator $validator) {
                $this->validate_booking($validator);
            },
        ];
    }

    protected function validate_booking(Validator $validator, ?Reservation $reservation = null): void
    {
        $is_edit = $reservation !== null;

        if ($validator->errors()->hasAny(['date', 'arrival', 'amount_of_people'])) {
            return;
        }

        $date = (string) $this->input('date');
        $arrival = (string) $this->input('arrival');

        $opening_datetime = OpeningDatetime::select(['open', 'opening', 'closing'])
            ->where('date', $date)
            ->first();

        if ($opening_datetime) {
            if (! $opening_datetime->open) {
                $validator->errors()->add('date', $is_edit
                    ? 'De aanpassing is niet gelukt, de nieuwe datum zijn wij helaas gesloten.'
                    : 'De ingevoerde datum zijn wij helaas gesloten.');

                return;
            }

            $opening_dt = new DateTime($opening_datetime->opening);
            $closing_dt = new DateTime($opening_datetime->closing);
            $requested_dt = DateTime::createFromFormat('H:i', $arrival);

            if ($requested_dt < $opening_dt || $requested_dt > $closing_dt) {
                $validator->errors()->add('arrival', $is_edit
                    ? "De nieuwe tijd ligt niet tussen onze speciale openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}."
                    : "De ingevoerde tijd ligt niet tussen onze speciale openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}.");

                return;
            }
        } else {
            $requested_day = (new DateTime($date))->format('N') - 1;
            $default_schedule = WeeklySchedule::select('is_open', 'opening', 'closing')
                ->where('day_of_week', $requested_day)
                ->first();

            if ($default_schedule) {
                if (! $default_schedule->is_open) {
                    $validator->errors()->add('date', $is_edit
                        ? 'De aanpassing is niet gelukt, de nieuwe datum zijn wij helaas gesloten.'
                        : 'De ingevoerde datum zijn wij helaas gesloten.');

                    return;
                }

                $opening_dt = new DateTime($default_schedule->opening);
                $closing_dt = new DateTime($default_schedule->closing);
                $requested_dt = DateTime::createFromFormat('H:i', $arrival);

                if ($requested_dt < $opening_dt || $requested_dt > $closing_dt) {
                    $validator->errors()->add('arrival', $is_edit
                        ? "De nieuwe tijd ligt niet tussen onze openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}."
                        : "De ingevoerde tijd ligt niet tussen onze openingstijden: {$opening_dt->format('H:i')} en {$closing_dt->format('H:i')}.");

                    return;
                }
            }
        }

        $current_date = now()->addDay()->format('Y-m-d');
        $future_date = now()->addDays(61)->format('Y-m-d');

        if ($current_date > $date) {
            $validator->errors()->add('date', $is_edit
                ? 'Voor de ingevoerde datum kan je niet meer je reservering aanpassen. Je moet ten minste 1 dag van te voren aanpassingen maken.'
                : 'Voor de ingevoerde datum kan je niet meer reserveren. Je moet ten minste 1 dag van te voren reserveren.');

            return;
        }

        if ($future_date < $date) {
            $validator->errors()->add('date', $is_edit
                ? 'Voor de ingevoerde datum kan je de reservering nog niet reserveren. Je kan maximaal 60 dagen van te voren reserveren.'
                : 'Voor de ingevoerde datum kan je nog niet reserveren. Je kan maximaal 60 dagen van te voren reserveren.');

            return;
        }

        $chairs_used = Reservation::where('date', $date)
            ->when($reservation, fn ($query) => $query->where('id', '!=', $reservation->id))
            ->sum('amount_of_people');

        if (Config::get('app.seats') - ($chairs_used + (int) $this->input('amount_of_people')) < 0) {
            $validator->errors()->add('amount_of_people', $is_edit
                ? 'De aanpassing is niet gelukt, helaas hebben we niet genoeg stoelen voor de aanpassing!'
                : 'De reservering is niet gelukt, helaas hebben we deze dag geen stoelen meer!');
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'U moet op een naam reserveren',
            'name.min' => 'U moet op een naam reserveren',
            'name.max' => 'De naam mag niet langer dan 255 karakters zijn',
            'amount_of_people.required' => 'U moet wel een aantal mensen invullen om te reserveren',
            'amount_of_people.numeric' => 'U moet een getal invullen bij het aantal mensen voor de reservering',
            'amount_of_people.max' => 'U kan niet via de form reserveren voor een groep van meer dan 10, bel het restaurant voor mogelijkheden',
            'amount_of_people.min' => 'U moet voor minimaal 1 persoon reserveren',
            'phone_number.required' => 'U moet uw telefoonnummer invullen om te reserveren',
            'phone_number.numeric' => 'Uw telefoonnummer kan alleen bestaan uit cijfers',
            'email.required' => 'U moet uw e-mailadres invullen om te reserveren',
            'email.email' => 'U moet een geldig e-mailadres invullen om te reserveren',
            'comment.max' => 'De opmerking mag niet langer dan 1024 karakters zijn',
            'date.required' => 'U moet een datum reserveren',
            'date.date_format' => 'De formatering van de datum is incorrect, moet \'Y-m-d\' zijn.',
            'arrival.required' => 'Een aankomsttijd is verplicht.',
            'arrival.regex' => 'De aankomsttijd is verkeerd ingevuld.',
        ];
    }
}
