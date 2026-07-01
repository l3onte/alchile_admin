<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = fake()->numberBetween(1 , 3);
        $precioUnitario = fake()->randomFloat(2, 35.00, 140.00);
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => $qty,
            'unit_price' => $precioUnitario,
            'subtotal' => $qty * $precioUnitario,    
        ];
    }
}
