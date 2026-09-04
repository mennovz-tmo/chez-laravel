<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description_short' => fake()->paragraph(2),
            'allergens' => [fake()->word()],
            'price' => fake()->numberBetween(1, 35),
            'picture' => fake()->filePath(),
        ];
    }
}
