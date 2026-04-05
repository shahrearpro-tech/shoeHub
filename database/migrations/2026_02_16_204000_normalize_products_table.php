<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rename columns to match codebase/migrations
            if (Schema::hasColumn('products', 'price') && !Schema::hasColumn('products', 'regular_price')) {
                $table->renameColumn('price', 'regular_price');
            }
            
            if (Schema::hasColumn('products', 'compare_price') && !Schema::hasColumn('products', 'sale_price')) {
                $table->renameColumn('compare_price', 'sale_price');
            }

            // Clean up redundant bestseller columns
            if (Schema::hasColumn('products', 'is_bestseller')) {
                // Transfer data if is_best_seller is 0 or null
                DB::table('products')
                    ->where('is_bestseller', 1)
                    ->update(['is_best_seller' => 1]);
                
                $table->dropColumn('is_bestseller');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'regular_price')) {
                $table->renameColumn('regular_price', 'price');
            }
            if (Schema::hasColumn('products', 'sale_price')) {
                $table->renameColumn('sale_price', 'compare_price');
            }
            if (!Schema::hasColumn('products', 'is_bestseller')) {
                $table->tinyint('is_bestseller')->default(0)->after('is_new');
            }
        });
    }
};
