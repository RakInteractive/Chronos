<?php

namespace App\Http\Resources;

use App\Models\LogEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin LogEntry */
class LogEntryResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'level' => $this->level,
            'labels' => $this->labels,
            'context' => $this->context,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'token_id' => $this->token_id,
        ];
    }
}
