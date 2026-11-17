<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();              // KODE kupon
            $table->string('name');                        // nama promo
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed']); // % atau nominal
            $table->decimal('value', 10, 2);               // nilai diskon
            $table->decimal('min_purchase', 12, 2)->default(0); // min belanja
            $table->decimal('max_discount', 10, 2)->nullable();  // maks potongan
            $table->integer('usage_limit')->nullable();    // batas pemakaian
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};

