<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\CashShift;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total = fake()->randomFloat(2, 120.00, 900.00);
        return [
            'cash_shift_id' => CashShift::factory(),
            'order_number' => fake()->unique()->randomNumber(5, true),
            'total_amount' => $total,
            'payment_amount' => $total + fake()->randomElement([0, 50, 100, 200]),
            'change_amount' => function (array $attributes) {
                return $attributes['payment_amount'] - $attributes['total_amount'];
            },
            'payment_method_id' => PaymentMethod::factory(),
            'status' => OrderStatus::COMPLETED,
        ];
    }
}
