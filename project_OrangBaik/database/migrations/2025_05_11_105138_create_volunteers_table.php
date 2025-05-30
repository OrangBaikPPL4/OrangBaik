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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_acara');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'dalam_proses', 'selesai', 'ditunda', 'dibatalkan'])->default('aktif');
            $table->integer('kuota_relawan')->default(0);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // Membuat tabel pivot untuk relasi many-to-many antara relawan dan volunteer
        Schema::create('relawan_volunteer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relawan_id')->constrained()->onDelete('cascade');
            $table->foreignId('volunteer_id')->constrained()->onDelete('cascade');
            $table->enum('status_kehadiran', ['belum hadir', 'hadir', 'tidak hadir'])->default('belum hadir');
            $table->timestamps();
            
            // Memastikan relawan hanya bisa mendaftar sekali per acara volunteer
            $table->unique(['relawan_id', 'volunteer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relawan_volunteer');
        Schema::dropIfExists('volunteers');
    }
};
