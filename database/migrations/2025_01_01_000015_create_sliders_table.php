<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('image_path', 255);
            $table->string('button_text', 50)->nullable();
            $table->string('button_link', 255)->nullable();
            $table->integer('display_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index('status');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};