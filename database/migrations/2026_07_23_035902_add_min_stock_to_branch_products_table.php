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
        Schema::table('branch_products', function (Blueprint $table) {
            $table->decimal('min_stock', 10, 4)->default(0)->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_products', function (Blueprint $table) {
            $table->dropColumn('min_stock');
        });
    }
};
