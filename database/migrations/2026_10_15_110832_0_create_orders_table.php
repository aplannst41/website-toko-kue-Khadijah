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
            $table->string('order_number')->unique();   // SCB-20241015-001
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', [
                'pending',       // menunggu pembayaran
                'paid',          // sudah bayar, menunggu verifikasi
                'verified',      // pembayaran terverifikasi
                'processing',    // sedang diproses/dibuat
                'ready',         // siap diambil/dikirim
                'delivered',     // sudah dikirim
                'completed',     // selesai
                'cancelled',     // dibatalkan
            ])->default('pending');
            $table->enum('delivery_type', ['pickup', 'delivery'])->default('pickup');
            $table->dateTime('delivery_date');          // tanggal ambil/kirim
            $table->string('delivery_time')->nullable(); // jam pengambilan
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('discount_code')->nullable();
            $table->text('note')->nullable();           // catatan order
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

