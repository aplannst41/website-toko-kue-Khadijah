<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable()->after('phone');
            $table->string('district')->nullable()->after('address');
            $table->string('city')->nullable()->default('Kota Lhokseumawe')->after('district');
            $table->string('province')->nullable()->default('Aceh')->after('city');
            $table->decimal('latitude', 10, 8)->nullable()->after('province');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'district', 'city', 'province', 'latitude', 'longitude']);
        });
    }
};
