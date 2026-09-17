<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'John Example',
            'email' => 'mail@example.com',
            'role' => 'owner',
        ]);
        $this->call(WeeklyScheduleSeeder::class);

        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $this->call(ReservationSeeder::class);
            }
            $this->call(OpeningDatetimeSeeder::class);
        }
        for ($i = 0; $i < 16; $i++) {
            $this->call(RecipeSeeder::class);
        }
    }
}
