<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recipe::factory(10)->create();

        Recipe::factory()->create([
            'name' => fake()->name(),
            'description_short' => fake()->paragraph(2),
            'allergens' => json_encode([fake()->word()]),
            'price' => fake()->numberBetween(1, 35),
            'picture' => fake()->filePath(),
        ]);
    }
}
