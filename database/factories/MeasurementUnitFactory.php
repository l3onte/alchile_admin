<?php

namespace Database\Factories;

use App\Models\MeasurementUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MeasurementUnit>
 */
class MeasurementUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'abbreviation' => fake()->unique()->lexify('???'),
        ];
    }
}
