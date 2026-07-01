<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\BranchSupply;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BranchSupply>
 */
class BranchSupplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supply_id' => Supply::factory(),
            'branch_id' => Branch::factory(),
            'quantity' => fake()->randomFloat(2, 20, 500),
            'unit_cost' => fake()->randomFloat(2, 10.00, 160.00),
            'min_stock' => fake()->randomFloat(2, 5, 30),
        ];
    }
}
