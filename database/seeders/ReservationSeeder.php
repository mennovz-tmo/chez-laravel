<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reservation::factory(10)->create();

        Reservation::factory()->create([
            'number' => generate_reservation_number(),
            'name' => fake()->name(),
            'amount_of_people' => fake()->numberBetween(1, 16),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'comment' => fake()->sentence(),
            'date' => fake()->date(),
            'arrival' => fake()->time('H:i'),
            'departure' => fake()->time(),
        ]);
    }
}
