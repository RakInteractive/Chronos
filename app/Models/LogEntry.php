<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Monolog\Level;

class LogEntry extends Model {
    use HasFactory;

    protected $fillable = [
        'token_id',
        'title',
        'content',
        'level',
        'labels',
        'context',
        'read_at',
        'created_at',
    ];

    protected static function boot(): void {
        parent::boot();
        static::created(function (LogEntry $entry) {
            $hooks = $entry
                ->token
                ->hooks()
                ->where('enabled', true)
                ->where('min_level', '<=', Level::fromName($entry->level))
                ->get();

            foreach ($hooks as $hook) {
                $hook->handle($entry);
            }
        });
    }

    public function token(): BelongsTo {
        return $this->belongsTo(Token::class);
    }

    protected function casts(): array {
        return [
            'labels' => 'array',
            'context' => 'array',
            'read_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }
}
