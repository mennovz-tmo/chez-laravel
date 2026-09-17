<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $euro = mt_rand(0, 50);
        $cent = mt_rand(0, 100);
        $price = $euro + ($cent / 100);

        Recipe::factory()->create([
            'name' => fake()->name(),
            'description_short' => fake()->paragraph(mt_rand(2, 4)),
            'allergens' => fake()->randomElement(['gluten', 'melk', 'mosterd']),
            'price' => $price,
            'picture' => fake()->filePath(),
        ]);
    }
}
