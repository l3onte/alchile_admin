<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use App\Models\Supplier;
use App\Models\Supply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $units = MeasurementUnit::all();

        for ($i = 0; $i < 20; $i++) {
            Supply::factory()->create([
                'supplier_id' => $suppliers->random()->id,
                'measurement_unit_id' => $units->random()->id,
            ]);
        }
    }
}
