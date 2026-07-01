<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchSupply;
use App\Models\Supply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $supplies = Supply::all();

        foreach($branches as $branch) {
            foreach($supplies as $supply) {
                BranchSupply::factory()->create([
                    'branch_id' => $branch->id,
                    'supply_id' => $supply->id,
                ]);
            }
        }
    }
}
