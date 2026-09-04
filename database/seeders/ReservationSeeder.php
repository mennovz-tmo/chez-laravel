<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('reservations')->insert([
                "number" => generate_reservation_number(),
                "name" => fake()->name(),
                "amount_of_people" => fake()->numberBetween(1, 16),
                "phone_number" => fake()->phoneNumber(),
                "email" => fake()->safeEmail(),
                "comment" => fake()->sentence(),
                "date" => fake()->date(),
                "arrival" => fake()->time(),
                "departure" => fake()->time(),
            ]);
        }
    }
}
