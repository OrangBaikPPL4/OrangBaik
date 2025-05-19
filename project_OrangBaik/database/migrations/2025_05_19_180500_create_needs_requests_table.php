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
        Schema::create('needs_requests', function (Blueprint $table) {
            $table->id();
            $table->string('requester_name');
            $table->string('item_name');
            $table->enum('category', ['Makanan','Obat','Pakaian','Lainnya']);
            $table->string('location');
            $table->enum('status', ['Pending','Diproses','Selesai'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('needs_requests');
    }
};
