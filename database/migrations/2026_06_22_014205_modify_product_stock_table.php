<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_stock', function (Blueprint $table) {
            $table->dropForeign('product_stock_branch_id_foreign'); 
            $table->dropUnique('product_stock_branch_id_product_id_unique');
            $table->date('expiration_date')->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('product_stock', function (Blueprint $table) {
            $table->dropColumn('expiration_date');
            $table->unique(['branch_id', 'product_id'], 'product_stock_branch_id_product_id_unique');
        });
    }
};