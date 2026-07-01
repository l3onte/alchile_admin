<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cash_shift_id')
                  ->constrained('cash_shifts');
            
            $table->integer('order_number')->index();
            $table->decimal('total_amount', 10, 4);
            $table->decimal('payment_amount', 10, 4);
            $table->decimal('change_amount', 10, 4);
            
            $table->foreignId('payment_method_id')
                  ->constrained('payment_methods');
        
            $table->enum('status', array_column(OrderStatus::cases(), 'value'))
                  ->default(OrderStatus::PENDING->value)
                  ->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
