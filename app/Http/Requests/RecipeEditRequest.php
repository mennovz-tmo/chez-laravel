<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class RecipeEditRequest extends RecipeCreateRequest
{
    /**
     * The edit form is rendered via GET; only validate on the POST update.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('GET')) {
            return [];
        }

        return [
            'name' => ['bail', 'required', 'string', 'min:1', 'max:255'],
            'description_short' => ['required', 'min:1', 'max:1024'],
            'allergens' => ['required', 'string', 'min:1'],
            'price' => ['required', 'decimal:2', 'min:0.01'],
            'picture' => ['nullable', 'image'],
        ];
    }
}
