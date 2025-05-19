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
        Schema::table('needs_requests', function (Blueprint $table) {
        if (!Schema::hasColumn('needs_requests', 'urgency')) {
            $table->enum('urgency', ['Tinggi','Sedang','Rendah'])
                  ->default('Sedang')
                  ->after('status');
        }

        $table->index('category');
        $table->index('location');
        $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('needs_requests', function (Blueprint $table) {
        $table->dropIndex(['category']);
        $table->dropIndex(['location']);
        $table->dropIndex(['status']);
        if (Schema::hasColumn('needs_requests', 'urgency')) {
            $table->dropColumn('urgency');
        }
        });
    }
};
