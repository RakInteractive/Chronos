<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component {
    public function render() {
        $tokens = \App\Models\Token::withCount([
            'logEntries as critical_unread_count' => function ($query) {
                $query->whereNull('read_at')->whereIn('level', ['error', 'alert', 'critical', 'emergency']);
            },
            'logEntries as unread_count' => function ($query) {
                $query->whereNull('read_at');
            }
        ])
            ->orderByDesc('critical_unread_count')
            ->orderByDesc('unread_count')
            ->orderByDesc(\App\Models\LogEntry::select('created_at')
                ->whereColumn('token_id', 'tokens.id')
                ->latest()
                ->take(1)
            )
            ->limit(8)
            ->with('logEntries')
            ->get();

        return view('livewire.dashboard')->with('tokens', $tokens);
    }
}
