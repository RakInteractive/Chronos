<?php

namespace App\Hooks;

use App\Models\Hook as HookModel;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

abstract class Hook {
    abstract public function run(LogEntry $logEntry, HookModel $hook): void;

    public function validateConfig(HookModel $hook, array $rules): array {
        $config = $hook->config;

        try {
            return validator($config, $rules)->validate();
        } catch (ValidationException $e) {
            $hook->update(['enabled' => false]);
            Log::warning("Disabling hook ($hook->id) $hook->name due to invalid configuration: " . $e->getMessage());
            return [];
        }
    }
}
