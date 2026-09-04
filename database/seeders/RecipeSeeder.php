<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('recipes')->insert([
                'name' => fake()->name(),
                'description_short' => fake()->paragraph(2),
                'allergens' => json_encode([fake()->word()]),
                'price' => fake()->numberBetween(1, 35),
                'picture' => fake()->filePath(),
            ]);
        }
    }
}
