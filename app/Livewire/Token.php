<?php

namespace App\Livewire;

use App\Models\LogEntry as LogEntryModel;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Token extends Component {
    use WithPagination;

    public \App\Models\Token $token;

    public function render(): View {
        $availableLabels = LogEntryModel::where('token_id', $this->token->id)
            ->pluck('labels')->flatten()->unique()->values();

        $entries = $this->token->logEntries()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.token')
            ->with('token', $this->token)
            ->with('entries', $entries)
            ->with('labels', $availableLabels);
    }

    public function openLogEntryModal(int $logEntryId): void {
        $this->dispatch('openLogEntryModal', $logEntryId);
    }
}
