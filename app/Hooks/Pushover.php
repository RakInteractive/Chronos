<?php

namespace App\Hooks;

use App\Models\Hook as HookModel;
use App\Models\LogEntry;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Pushover extends Hook {

    public function run(LogEntry $logEntry, HookModel $hook): void {
        $config = $this->validateConfig($hook, [
            'user' => 'required|string',
            'sound' => 'sometimes|string',
        ]);

        if (empty($config)) {
            return;
        }

        $data = [
            'token' => config('chronos.pushover.token'),
            'user' => $config['user'],
            'title' => "[{$hook->token->name}][$logEntry->level] " . Str::limit($logEntry->title, 30),
            'message' => Str::limit($logEntry->title, 512),
            'url' => config('app.url') . "/token/$logEntry->token_id?entry=" . $logEntry->id,
            'url_title' => 'View Log Entry',
            'sound' => $config['sound'] ?? 'pushover',
            'timestamp' => $logEntry->created_at->timestamp,
            'priority' => match ($logEntry->level) {
                'emergency', 'alert', 'critical', 'error' => 1,
                'warning' => 0,
                default => -1,
            },
        ];

        try {
            $response = Http::asForm()->post('https://api.pushover.net/1/messages.json', $data);

            if ($response->failed()) {
                $hook->update(['enabled' => false]);
                Log::warning("Disabling hook ($hook->id) $hook->name due to error: " . $response->body());
                return;
            }
        } catch (ConnectionException $e) {
            $hook->update(['enabled' => false]);
            Log::warning("Disabling hook ($hook->id) $hook->name due to connection error: " . $e->getMessage());
            return;
        }
    }
}
