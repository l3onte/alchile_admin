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
        Schema::create('cash_shifts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cash_register_id')
                  ->constrained('cash_registers');

            $table->foreignId('user_id')
                  ->constrained('users');

            $table->decimal('opening_cash', 10, 4);

            $table->decimal('closing_cash_estimated', 10, 4)->nullable();
            $table->decimal('closing_cash_real', 10, 4)->nullable();

            $table->enum('status', ['open', 'closed'])->default('open');

            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_shifts');
    }
};
