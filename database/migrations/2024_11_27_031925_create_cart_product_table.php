<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->foreignUuid('cartId')->constrained('carts')->cascadeOnDelete();
            $table->foreignUuid('productId')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->primary(['cartId', 'productId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_product');
    }
};
