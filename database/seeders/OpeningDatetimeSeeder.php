<?php

namespace Database\Seeders;

use App\Models\OpeningDatetime;
use Illuminate\Database\Seeder;

class OpeningDatetimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OpeningDatetime::factory()->create([
            'date' => fake()->date('Y-m-d'),
            'open' => fake()->boolean(80),
            'opening' => fake()->time('H:i'),
            'closing' => fake()->time('H:i'),
        ]);
    }
}
