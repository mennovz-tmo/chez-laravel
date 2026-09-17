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
        $hour = mt_rand(8, 15);
        $minute = mt_rand(0, 59);
        $open = "$hour:$minute";
        $hour += mt_rand(2, 8);
        $close = "$hour:$minute";

        OpeningDatetime::factory()->create([
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'open' => fake()->boolean(65),
            'opening' => $open,
            'closing' => $close,
        ]);
    }
}
