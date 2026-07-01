<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MeasurementUnitSeeder::class,
            PaymentMethodSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);

        $this->call([
            SupplySeeder::class,
            BranchSeeder::class,
        ]);

        $this->call([
            BranchProductSeeder::class,
            BranchSupplySeeder::class,
            RecipeDetailSeeder::class,
            CashRegisterSeeder::class,
        ]);

        if (app()->environment('local', 'testing')) {
            $this->call([
                TransactionalSeeder::class,
            ]);
        }
    }
}
