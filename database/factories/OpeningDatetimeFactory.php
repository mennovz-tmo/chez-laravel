<?php

namespace Database\Factories;

use App\Models\OpeningDatetime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OpeningDatetime>
 */
class OpeningDatetimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => now()->toDateString(),
            'open' => true,
            'opening' => '11:00',
            'closing' => '22:00',
        ];
    }
}
