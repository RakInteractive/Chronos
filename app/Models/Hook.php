<?php

namespace App\Models;

use App\Hooks\Mail;
use App\Hooks\Pushover;
use App\Hooks\Teams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hook extends Model {
    protected $guarded = [];

    public function token(): BelongsTo {
        return $this->belongsTo(Token::class);
    }

    protected function casts(): array {
        return [
            'enabled' => 'boolean',
            'config' => 'array',
        ];
    }

    public function handle(LogEntry $logEntry): void {
        switch ($this->type) {
            case 'mail':
                (new Mail())->run($logEntry, $this);
                break;
            case 'teams':
                (new Teams())->run($logEntry, $this);
                break;
            case 'pushover':
                (new Pushover())->run($logEntry, $this);
                break;
            default:
                // Unknown hook type
                break;
        }
    }
}
