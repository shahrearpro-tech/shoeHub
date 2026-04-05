<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->enum('attribute_name', ['size', 'color', 'material', 'gender', 'style']);
            $table->string('attribute_value', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('product_id');
            $table->index(['attribute_name', 'attribute_value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};