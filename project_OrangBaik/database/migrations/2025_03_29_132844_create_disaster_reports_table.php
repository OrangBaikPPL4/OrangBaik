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
        Schema::create('disaster_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('lokasi');
            $table->enum('jenis_bencana', ['banjir', 'gempa', 'kebakaran', 'longsor', 'lainnya']);
            $table->text('deskripsi');
            $table->json('bukti_media')->nullable(); 
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_reports');
    }
};
