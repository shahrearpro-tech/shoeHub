<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number', 50)->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('customer_name', 100);
            $table->string('customer_email', 100);
            $table->string('customer_phone', 20);
            $table->string('shipping_address_line1', 255);
            $table->string('shipping_address_line2', 255)->nullable();
            $table->string('shipping_city', 100);
            $table->string('shipping_state', 100)->nullable();
            $table->string('shipping_postal_code', 20);
            $table->string('shipping_country', 100)->default('Bangladesh');
            $table->enum('delivery_option', ['standard', 'express', 'same_day'])->default('standard');
            $table->decimal('delivery_charge', 10, 2)->default(0.00);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cod', 'bkash', 'nagad', 'card', 'bank_transfer'])->default('cod');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('order_status', ['pending', 'processing', 'on_hold', 'shipped', 'out_for_delivery', 'delivered', 'cancelled', 'refunded'])->default('pending');
            $table->text('order_notes')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('order_number');
            $table->index('user_id');
            $table->index('order_status');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};