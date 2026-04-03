<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Product এর variations (size/color/material etc)
        // উদাহরণ: একটা T-Shirt এর Size: S, M, L, XL এবং Color: Red, Blue

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->unique()->nullable();
            $table->json('attributes'); // {"size": "M", "color": "Red"}
            $table->decimal('price_adjustment', 10, 2)->default(0); // base price থেকে +/- কত
            $table->integer('stock_quantity')->default(0);
            $table->string('image')->nullable(); // variant specific image
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
