<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ORD-2024-00001
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();

            // Shipping address (snapshot - user address পরে change হলেও order ঠিক থাকবে)
            $table->string('shipping_name');
            $table->string('shipping_phone', 20);
            $table->string('shipping_address_line1');
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code', 20)->nullable();
            $table->string('shipping_country', 2)->default('BD');

            // Pricing breakdown
            $table->decimal('subtotal', 10, 2);       // items total (before discount)
            $table->decimal('discount_amount', 10, 2)->default(0); // coupon discount
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);   // final amount customer pays

            // Status
            $table->enum('status', [
                'pending',      // order placed, payment pending
                'confirmed',    // payment received
                'processing',   // being packed
                'shipped',      // dispatched
                'delivered',    // customer received
                'cancelled',    // cancelled
                'refunded',     // refund done
            ])->default('pending');

            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'partially_refunded',
                'refunded',
            ])->default('unpaid');

            $table->string('payment_method')->nullable(); // bkash, nagad, card, cod

            // Shipping info
            $table->string('tracking_number')->nullable();
            $table->string('shipping_carrier')->nullable(); // Pathao, Steadfast, etc.
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
