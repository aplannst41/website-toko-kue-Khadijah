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
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name');            // snapshot nama produk
            $table->string('variant_info')->nullable(); // snapshot info varian
            $table->integer('quantity');
            $table->decimal('price', 12, 2);           // harga saat pesan
            $table->decimal('subtotal', 12, 2);
            $table->string('cake_text')->nullable();   // tulisan di kue
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

