<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class ReservationEditRequest extends ReservationCreateRequest
{
    /**
     * Only staff or the verified account that owns the reservation (by
     * matching e-mail) may view or update an existing reservation.
     */
    public function authorize(): bool
    {
        if (is_staff()) {
            return true;
        }

        $reservation = $this->route('reservation');

        return $reservation !== null
            && $this->user()?->hasVerifiedEmail()
            && $this->user()->email === $reservation->email;
    }

    /**
     * The edit form is rendered via GET; only validate on the POST update.
     */
    public function rules(): array
    {
        return $this->isMethod('GET') ? [] : parent::rules();
    }

    /**
     * Validate against the special opening times, weekly schedule, date range
     * and seat availability, excluding the reservation that is being edited.
     *
     * @return array<int, callable>
     */
    protected function after(): array
    {
        if ($this->isMethod('GET')) {
            return [];
        }

        return [
            function (Validator $validator) {
                $this->validate_booking($validator, $this->route('reservation'));
            },
        ];
    }
}
