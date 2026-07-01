<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $products = Product::all();

        foreach ($branches as $branch) {
            foreach ($products as $product) {
                BranchProduct::factory()->create([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
