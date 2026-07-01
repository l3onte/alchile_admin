<?php

namespace Database\Factories;

use App\Enums\SupplyMovementType;
use App\Models\Branch;
use App\Models\Supply;
use App\Models\SupplyMovement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplyMovement>
 */
class SupplyMovementFactory extends Factory
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
            'supply_id' => Supply::factory(),
            'movement_type' => fake()->randomElement(SupplyMovementType::cases()),
            'description' => fake()->sentence(),
            'quantity' => fake()->randomFloat(2, 2, 50),
        ];
    }
}
