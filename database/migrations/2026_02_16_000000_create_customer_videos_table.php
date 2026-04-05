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
        Schema::create('customer_videos', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('customer_name');
            $blueprint->string('video_url');
            $blueprint->string('thumbnail_url')->nullable();
            $blueprint->text('comment')->nullable();
            $blueprint->boolean('is_featured')->default(false);
            $blueprint->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_videos');
    }
};
