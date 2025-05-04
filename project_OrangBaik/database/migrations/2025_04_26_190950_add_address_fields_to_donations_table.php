<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('negara')->default('Indonesia')->after('user_id');
            $table->string('provinsi')->nullable()->after('negara');
            $table->string('kota')->nullable()->after('provinsi');
            $table->string('alamat_jalan')->nullable()->after('kota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['negara', 'provinsi', 'kota', 'alamat_jalan']);
        });
    }
};
