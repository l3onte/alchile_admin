<?php

namespace Database\Factories;

use App\Enums\ProductMovementType;
use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductMovement>
 */
class ProductMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'branch_id' => Branch::factory(),
            'product_id' => Product::factory(),
            'order_id' => null,
            'quantity' => fake()->numberBetween(1, 30),
            'movement_type' => fake()->randomElement(ProductMovementType::cases()),
            'description' => fake()->sentence(),
        ];
    }
}
