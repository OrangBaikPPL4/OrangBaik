<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_status_histories');
    }
}; 