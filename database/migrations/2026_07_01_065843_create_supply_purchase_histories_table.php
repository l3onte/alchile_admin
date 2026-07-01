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
        Schema::create('supply_purchase_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branch_id')
                  ->constrained('branches');

            $table->foreignId('supply_id')
                  ->constrained('supplies');

            $table->foreignId('supplier_id')
                  ->constrained('suppliers');

            $table->decimal('quantity_purchased', 10, 4);
            $table->decimal('unit_cost_paid', 10, 4);
            $table->timestamp('purchased_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_purchase_histories');
    }
};
