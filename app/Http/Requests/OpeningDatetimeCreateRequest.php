<?php

namespace App\Http\Requests;

use App\Models\OpeningDatetime;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class OpeningDatetimeCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_staff();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'open' => ['required', 'boolean'],
            'opening' => ['nullable', 'date_format:H:i'],
            'closing' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'De datum is verplicht.',
            'date.date' => 'De ingevulde datum is niet geldig.',
            'open.required' => 'Geef aan of jullie geopend zijn op deze datum.',
            'open.boolean' => 'De ingevulde waarde voor geopend zijn is niet geldig.',
            'opening.date_format' => 'De openingstijd moet een geldige tijd zijn in het formaat \'H:i\'.',
            'closing.date_format' => 'De sluitingstijd moet een geldige tijd zijn in het formaat \'H:i\'.',
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
                $this->validate_opening_datetime($validator);
            },
        ];
    }

    protected function validate_opening_datetime(Validator $validator, ?OpeningDatetime $openingDatetime = null): void
    {
        if ($validator->errors()->hasAny(['date', 'open'])) {
            return;
        }

        $date = (string) $this->input('date');

        $duplicate_exists = OpeningDatetime::where('date', $date)
            ->when($openingDatetime, fn ($query) => $query->where('id', '!=', $openingDatetime->id))
            ->exists();

        if ($duplicate_exists) {
            $validator->errors()->add('date', 'De ingevulde datum heeft al speciale data.');

            return;
        }

        if ($this->input('open') && (! $this->filled('opening') || ! $this->filled('closing'))) {
            $validator->errors()->add('opening', 'Als je open bent moet je wel tijden aangeven dat je open bent.');

            return;
        }

        $opening = DateTime::createFromFormat('H:i', $this->input('opening') ?? '');
        $closing = DateTime::createFromFormat('H:i', $this->input('closing') ?? '');

        if ($opening > $closing) {
            $validator->errors()->add('opening', 'De opening is na de sluiting.');
        }
    }
}
