<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->uuid('token')->unique()->default(DB::raw('(UUID())'));
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tokens');
    }
};
