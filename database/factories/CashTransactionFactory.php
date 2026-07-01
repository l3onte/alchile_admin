<?php

namespace Database\Factories;

use App\Enums\CashTransactionType;
use App\Models\CashShift;
use App\Models\CashTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CashTransaction>
 */
class CashTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cash_shift_id' => CashShift::factory(),
            'type' => fake()->randomElement(CashTransactionType::cases()),
            'amount' => fake()->randomFloat(2, 20.00, 300.00),
            'description' => fake()->randomElement(['Pago de factura de luz', 'Compra de hielo de emergencia', 'Arqueo de caja - Ajuste']),
        ];
    }
}
