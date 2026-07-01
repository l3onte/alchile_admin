<?php

use App\Enums\CashTransactionType;
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
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cash_shift_id')
                  ->constrained('cash_shifts');

            $table->enum('type', array_column(CashTransactionType::cases(), 'value'));

            $table->decimal('amount', 10, 4);
            $table->string('description', 300)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transactions');
    }
};
