<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\CashRegister;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CashRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        foreach ($branches as $branch) {
            CashRegister::factory()->create([
                'branch_id' => $branch->id,
                'name' => 'Caja Principal 01',
            ]);

            CashRegister::factory()->create([
                'branch_id' => $branch->id,
                'name' => 'Caja Barra 02',
            ]);
        }
    }
}
