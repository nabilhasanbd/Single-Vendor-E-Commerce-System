<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();

            // Snapshot - order এর সময়ের data preserve করতে হবে
            // কারণ পরে product name বা price change হতে পারে
            $table->string('product_name');          // snapshot
            $table->json('variant_attributes')->nullable(); // {"size":"M","color":"Red"} snapshot
            $table->string('product_sku')->nullable(); // snapshot
            $table->string('product_image')->nullable(); // snapshot

            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);    // order এর সময়ের price
            $table->decimal('total_price', 10, 2);   // quantity * unit_price

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
