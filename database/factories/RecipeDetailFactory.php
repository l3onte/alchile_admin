<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\RecipeDetail;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecipeDetail>
 */
class RecipeDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'supply_id' => Supply::factory(),
            'quantity' => fake()->randomFloat(2, 5, 150),
        ];
    }
}
