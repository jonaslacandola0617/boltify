<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignUuid('orderId')->constrained('orders')->cascadeOnDelete();
            $table->foreignUuid('productId')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->primary(['orderId', 'productId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
