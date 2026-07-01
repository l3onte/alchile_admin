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
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users');

            $table->foreignId('branch_id')
                 ->constrained('branches');

            $table->foreignId('supply_id')
                 ->constrained('supplies');

            $table->decimal('quantity', 10, 4);
            $table->decimal('cost_lost', 10, 4);

            $table->string('reason', 255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
