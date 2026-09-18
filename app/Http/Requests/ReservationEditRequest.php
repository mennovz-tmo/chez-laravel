<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class ReservationEditRequest extends ReservationCreateRequest
{
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
