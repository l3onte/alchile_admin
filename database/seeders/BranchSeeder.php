<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Branch::factory()->create([
            'admin_id' => $users->first()->id,
            'branch_name' => 'Al Chile - Guadalupe',
        ]);

        Branch::factory()->create([
            'admin_id' => $users->random()->id,
            'branch_name' => 'Al Chile - Campus Medico',
        ]);
    }
}
