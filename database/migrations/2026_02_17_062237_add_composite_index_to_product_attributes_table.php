<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds composite index for faster attribute lookups.
     */
    public function up(): void
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            // Composite index for product_id + attribute_name
            // Optimizes queries like: WHERE product_id = X AND attribute_name = 'color'
            $table->index(['product_id', 'attribute_name'], 'idx_product_attribute');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropIndex('idx_product_attribute');
        });
    }
};
