<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Token extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'token',
    ];

    protected function casts(): array {
        return [
            'token' => 'string',
        ];
    }

    public function logEntries(): HasMany {
        return $this->hasMany(LogEntry::class);
    }

    public function regenerate(): string {
        $this->update([
            'token' => Str::uuid()->toString(),
        ]);

        return $this->token;
    }

    public function unreadLogEntries(): Collection {
        return $this->logEntries()->where('read_at', null)->get();
    }

    public function criticalLogEntries(): Collection {
        return $this->unreadLogEntries()->whereIn('level', ['error', 'alert', 'critical', 'emergency']);
    }
}
