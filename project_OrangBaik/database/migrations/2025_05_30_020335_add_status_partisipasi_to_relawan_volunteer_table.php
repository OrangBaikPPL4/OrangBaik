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
        Schema::table('relawan_volunteer', function (Blueprint $table) {
            $table->string('status_partisipasi')->default('pending')->after('volunteer_event_role_id'); // Default status is 'pending'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relawan_volunteer', function (Blueprint $table) {
            $table->dropColumn('status_partisipasi');
        });
    }
};
