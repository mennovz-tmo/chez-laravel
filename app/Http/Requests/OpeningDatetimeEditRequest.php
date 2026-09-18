<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class OpeningDatetimeEditRequest extends OpeningDatetimeCreateRequest
{
    /**
     * The edit form is rendered via GET; only validate on the POST update.
     */
    public function rules(): array
    {
        return $this->isMethod('GET') ? [] : parent::rules();
    }

    /**
     * Run the checks against the special opening times, excluding the entry
     * that is being edited from the duplicate-date check.
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
                $this->validate_opening_datetime($validator, $this->route('openingDatetime'));
            },
        ];
    }
}
