<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branch_supplies', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('supply_id')
                  ->constrained('supplies');

            $table->foreignId('branch_id')
                  ->constrained('branches');

            $table->decimal('quantity', 10, 4);

            $table->decimal('unit_cost', 10, 4);

            $table->decimal('min_stock', 10, 4);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_supplies');
    }
};
