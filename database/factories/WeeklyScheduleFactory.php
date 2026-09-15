<?php

namespace Database\Factories;

use App\Models\WeeklySchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeeklySchedule>
 */
class WeeklyScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day_of_week' => 0,
            'is_open' => true,
            'opening' => '16:00',
            'closing' => '22:00',
        ];
    }
}
