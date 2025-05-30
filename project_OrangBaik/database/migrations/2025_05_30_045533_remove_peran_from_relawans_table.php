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
        Schema::table('relawans', function (Blueprint $table) {
            $table->dropColumn('peran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relawans', function (Blueprint $table) {
            $table->string('peran')->nullable(); // Add back the peran field if migration is rolled back
        });
    }
};
