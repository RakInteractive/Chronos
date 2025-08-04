<?php

namespace Database\Factories;

use App\Models\LogEntry;
use App\Models\Token;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TokenFactory extends Factory {
    protected $model = Token::class;

    public function definition() {
        return [
            'name' => $this->faker->name(),
            'token' => Str::uuid()->toString(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function configure() {
        return $this->afterCreating(function (Token $token) {
            $token->logEntries()->createMany(LogEntry::factory(random_int(0,5))->make()->toArray());
        });
    }
}
