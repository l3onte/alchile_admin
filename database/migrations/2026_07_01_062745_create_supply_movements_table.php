<?php

use App\Enums\ProductMovementType;
use App\Enums\SupplyMovementType;
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
        Schema::create('supply_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users');

            $table->foreignId('branch_id')
                  ->constrained('branches');

            $table->foreignId('supply_id')
                  ->constrained('supplies');

            $table->enum('movement_type', array_column(SupplyMovementType::cases(), 'value'));

            $table->string('description', 255)->nullable();

            $table->decimal('quantity', 10, 4);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_movements');
    }
};
