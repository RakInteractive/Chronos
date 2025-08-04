<?php

namespace App\Livewire;

use Livewire\Component;

class Token extends Component {
    public \App\Models\Token $token;

    public function render() {
        $availableLabels = \App\Models\LogEntry::where('token_id', $this->token->id)
            ->pluck('labels')->flatten()->unique()->values();

        return view('livewire.token')
            ->with('token', $this->token)
            ->with('labels', $availableLabels);
    }

    public function openLogEntryModal(int $logEntryId): void {
        $this->dispatch('openLogEntryModal', $logEntryId);
    }
}
