<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('addons', function (Blueprint $table) {
			$table->id();
			$table->string('slug')->unique();
			$table->boolean('enabled')->default(false);
			$table->dateTime('installed_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->dateTime('last_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->json('settings')->nullable();
		});
	}

	public function down(): void {
		Schema::dropIfExists('addons');
	}
};
