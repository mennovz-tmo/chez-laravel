<?php

namespace Database\Seeders;

use App\Models\WeeklySchedule;
use Illuminate\Database\Seeder;

class WeeklyScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 7; $i++) {
            WeeklySchedule::factory()->create([
                'day_of_week' => $i,
            ]);
        }
    }
}
