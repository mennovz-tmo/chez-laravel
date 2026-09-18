<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RecipeCreateRequest extends FormRequest
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
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'description_short' => ['required', 'min:1', 'max:1024'],
            'allergens' => ['required', 'string', 'min:1'],
            'price' => ['required', 'decimal:2', 'min:0.01'],
            'picture' => ['required', 'image'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'De naam is verplicht.',
            'name.min' => 'De naam moet minimaal 1 karakter bevatten.',
            'name.max' => 'De naam mag niet langer dan 255 karakters zijn.',
            'description_short.required' => 'De korte omschrijving is verplicht.',
            'description_short.min' => 'De korte omschrijving moet minimaal 1 karakter bevatten.',
            'description_short.max' => 'De korte omschrijving mag niet langer dan 1024 karakters zijn.',
            'allergens.required' => 'De allergenen zijn verplicht.',
            'allergens.min' => 'De allergenen moeten minimaal 1 karakter bevatten.',
            'price.required' => 'De prijs is verplicht.',
            'price.decimal' => 'De prijs moet een getal zijn met 2 decimalen.',
            'price.min' => 'De prijs moet minimaal 0.01 zijn.',
            'picture.required' => 'Een afbeelding is verplicht.',
            'picture.image' => 'Het ingevoerde bestand moet een afbeelding zijn.',
        ];
    }
}
