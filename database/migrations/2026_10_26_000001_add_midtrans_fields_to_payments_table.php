<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom method agar bertipe string/varchar sehingga fleksibel untuk midtrans maupun transfer manual
        Schema::table('payments', function (Blueprint $table) {
            $table->string('method', 50)->change();
            $table->string('snap_token')->nullable()->after('proof_image');
            $table->string('transaction_id')->nullable()->after('snap_token');
            $table->string('payment_type', 50)->nullable()->after('transaction_id');
            $table->longText('payment_response')->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'transaction_id', 'payment_type', 'payment_response']);
        });
    }
};
