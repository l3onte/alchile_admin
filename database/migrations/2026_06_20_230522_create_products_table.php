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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_category')
                   ->constrained('products_categories');
            $table->string('sku')
                   ->unique();
            $table->string('name');
            $table->string('type');
            $table->decimal('purchase_price', 10, 2)
                  ->default(0);
            $table->decimal('sell_price', 10, 2)
                  ->default(0);
            $table->string('unit')
                   ->default('unidad');
            $table->foreignId('edited_by')
                  ->nullable()
                  ->constrained('users');
            $table->date('expiration_date')
                  ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
