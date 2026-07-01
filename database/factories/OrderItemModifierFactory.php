<?php

namespace Database\Factories;

use App\Enums\OrderModifierAction;
use App\Models\OrderDetail;
use App\Models\OrderItemModifier;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItemModifier>
 */
class OrderItemModifierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_detail_id' => OrderDetail::factory(),
            'supply_id' => Supply::factory(),
            'action' => fake()->randomElement(OrderModifierAction::cases()),
            'extra_price' => fake()->randomElement([0.00, 15.00, 25.00]),
        ];
    }
}
