<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();

            $table->string('transaction_id')->nullable()->unique(); // gateway থেকে আসা ID
            $table->string('gateway_reference')->nullable(); // bKash/Nagad এর ref number

            $table->string('payment_method'); // bkash, nagad, card, cod, bank_transfer
            $table->string('payment_gateway')->nullable(); // sslcommerz, aamarpay, bkash, etc.

            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('BDT');

            $table->enum('status', [
                'initiated',  // payment শুরু হয়েছে
                'pending',    // gateway এ গেছে, response আসেনি
                'completed',  // সফল
                'failed',     // failed
                'cancelled',  // user cancel করেছে
                'refunded',   // refund হয়েছে
            ])->default('initiated');

            $table->json('gateway_response')->nullable(); // full gateway response log
            $table->string('failure_reason')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
