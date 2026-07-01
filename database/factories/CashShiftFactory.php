<?php

namespace Database\Factories;

use App\Enums\CashShiftStatus;
use App\Models\CashRegister;
use App\Models\CashShift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CashShift>
 */
class CashShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cash_register_id' => CashRegister::factory(),
            'user_id' => User::factory(),
            'opening_cash' => fake()->randomFloat(2, 500.00, 1000.00),
            'closing_cash_estimated' => fake()->randomFloat(2, 4000.00, 18000.00),
            'closing_cash_real' => fake()->randomFloat(2, 4000.00, 18000.00),
            'status' => CashShiftStatus::CLOSED,
            'opened_at' => fake()->dateTimeBetween('-1 month', '-1 day'),
            'closed_at' => function (array $attributes) {
                return Carbon::parse($attributes['opened_at'])->addHours(8);
            }
        ];
    }
}
