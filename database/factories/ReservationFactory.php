<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "number" => generate_reservation_number(),
            "name" => fake()->name(),
            "amount_of_people" => fake()->numberBetween(1, 16),
            "phone_number" => fake()->phoneNumber(),
            "email" => fake()->safeEmail(),
            "comment" => fake()->sentence(),
            "date" => fake()->date(),
            "arrival" => fake()->time(),
            "departure" => fake()->time(),
        ];
    }
}
