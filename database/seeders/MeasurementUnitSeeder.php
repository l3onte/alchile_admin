<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasurementUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = [
            ['name' => 'Kilogramos', 'abbreviation' => 'kg'],
            ['name' => 'Gramos', 'abbreviation' => 'g'],
            ['name' => 'Litros', 'abbreviation' => 'l'],
            ['name' => 'Mililitros', 'abbreviation' => 'ml'],
            ['name' => 'Unidades', 'abbreviation' => 'und'],
            ['name' => 'Porciones', 'abbreviation' => 'porc'],
        ];

        foreach ($unidades as $unidad) {
            MeasurementUnit::create($unidad);
        }
    }
}
