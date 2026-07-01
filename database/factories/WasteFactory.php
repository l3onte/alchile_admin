<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Supply;
use App\Models\User;
use App\Models\Waste;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Waste>
 */
class WasteFactory extends Factory
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
            'quantity' => fake()->randomFloat(2, 0.5, 10),
            'cost_lost' => fake()->randomFloat(2, 30.00, 500.00),
            'reason' => fake()->randomElement(['Producto Expirado', 'Mal estado', 'Caida/Derrame'])
        ];
    }
}
