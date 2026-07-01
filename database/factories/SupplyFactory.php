<?php

namespace Database\Factories;

use App\Models\MeasurementUnit;
use App\Models\Supplier;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supply>
 */
class SupplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'measurement_unit_id' => MeasurementUnit::factory(),
            'name' => fake()->unique()->word() . ' Fake',
            'status' => true,
        ];
    }
}
