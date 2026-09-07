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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Menno',
            'email' => 'menno@themindoffice.nl',
        ]);

        for ($i = 0; $i < 2; $i++) {
            $this->call(RecipeSeeder::class);
            $this->call(ReservationSeeder::class);
        }
    }
}
