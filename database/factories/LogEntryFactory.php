<?php

namespace Database\Factories;

use App\Models\LogEntry;
use App\Models\Token;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LogEntryFactory extends Factory {
    protected $model = LogEntry::class;

    public function definition(): array {
        return [
            'title' => $this->faker->text(50),
            'content' => $this->faker->text(300),
            'level' => $this->faker->randomElement(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency']),
            'labels' => $this->faker->words(),
            'context' => $this->faker->words(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'read_at' => $this->faker->boolean(25) ? $this->faker->dateTime() : null,
        ];
    }
}
