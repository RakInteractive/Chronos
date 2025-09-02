<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('log_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('token_id')->constrained('tokens')->onDelete('cascade');
            $table->text('title');
            $table->longText('content');
            $table->enum('level', ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])->default('info');
            $table->json('labels')->nullable();
            $table->json('context')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('log_entries');
    }
};
