<?php

use App\Enums\OrderModifierAction;
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
        Schema::create('order_item_modifiers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_detail_id')
                  ->constrained('order_details');

            $table->foreignId('supply_id')
                  ->constrained('supplies');

            $table->enum('action', array_column(OrderModifierAction::cases(), 'value'));

            $table->decimal('extra_price', 10, 4)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_modifiers');
    }
};
