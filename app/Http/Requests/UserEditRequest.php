<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_owner();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => ['required', 'string', Rule::in(['staff', 'consumer'])],
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
                if ($validator->errors()->has('email')) {
                    return;
                }

                $user = $this->route('user');

                $email_exists = User::where('email', $this->input('email'))
                    ->where('id', '!=', $user->id)
                    ->exists();

                if ($email_exists) {
                    $validator->errors()->add('email', 'Het email dat is ingevuld wordt al gebruikt door een andere gebruiker.');
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Een nieuwe naam is verplicht.',
            'name.max' => 'De naam mag niet langer dan 255 karakters.',
            'email.required' => 'Een e-mailadres is verplicht.',
            'email.email' => 'Het ingevulde e-mailadres is niet geldig.',
            'email.max' => 'Het e-mailadres mag niet langer dan 255 karakters zijn.',
            'role.required' => 'Een rol is verplicht.',
            'role.in' => 'De ingevoerde rol is ongeldig en kan alleen \'staff\' of \'gebruiker\' zijn.',
        ];
    }
}
