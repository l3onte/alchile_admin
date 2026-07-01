<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Supply;
use App\Models\SupplyPurchaseHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplyPurchaseHistory>
 */
class SupplyPurchaseHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id' => Branch::factory(),
            'supply_id' => Supply::factory(),
            'supplier_id' => Supplier::factory(),
            'quantity_purchased' => fake()->randomFloat(2, 10, 200),
            'unit_cost_paid' => fake()->randomFloat(2, 12.00, 150.00),
            'purchased_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
