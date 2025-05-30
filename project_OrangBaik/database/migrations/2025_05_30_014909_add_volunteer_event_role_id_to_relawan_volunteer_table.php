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
            $table->foreignId('volunteer_event_role_id')->nullable()->constrained('volunteer_event_roles')->onDelete('set null')->after('volunteer_id'); // Assumes 'volunteer_id' column exists and you want to place the new column after it.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relawan_volunteer', function (Blueprint $table) {
            $table->dropForeign(['volunteer_event_role_id']);
            $table->dropColumn('volunteer_event_role_id');
        });
    }
};
