<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\RecipeDetail;
use App\Models\Supply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $supplies = Supply::all();

        foreach ($products as $product) {
            $randomSupplies = $supplies->random(rand(2, 4));
            foreach ($randomSupplies as $supply) {
                RecipeDetail::factory()->create([
                    'product_id' => $product->id,
                    'supply_id' => $supply->id,
                ]);
            }
        }
    }
}
