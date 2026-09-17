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

        $hour = mt_rand(16, 21);
        $minute = mt_rand(0, 59);
        $arrival = "$hour:$minute";
        $hour += 2;
        $departure = "$hour:$minute";

        Reservation::factory()->create([
            'number' => generate_reservation_number(),
            'name' => fake()->name(),
            'amount_of_people' => fake()->numberBetween(1, 10),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'comment' => fake()->sentence(),
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'arrival' => $arrival,
            'departure' => $departure,
        ]);
    }
}
