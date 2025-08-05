<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('log_entries', function (Blueprint $table) {
            // Drop the old auto-incrementing id column
            $table->dropColumn('id');
        });

        Schema::table('log_entries', function (Blueprint $table) {
            // Add uuid primary key
            $table->uuid('id')->primary()->first();
        });
    }

    public function down(): void {
        Schema::table('log_entries', function (Blueprint $table) {
            // Drop the uuid id column
            $table->dropColumn('id');
        });

        Schema::table('log_entries', function (Blueprint $table) {
            // Restore the auto-incrementing id column
            $table->id()->first();
        });
    }
};