<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogEntry extends Model {
    use HasFactory, HasUuids;

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

    public function token(): BelongsTo {
        return $this->belongsTo(Token::class);
    }

    protected function casts(): array {
        return [
            'labels' => 'array',
            'context' => 'array',
            'read_at' => 'datetime',
        ];
    }
}
