<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class LogEntry extends Component {
    public \App\Models\LogEntry $logEntry;
    public bool $open = false;

    #[On('openLogEntryModal')]
    public function openLogEntryModal(string $logEntryId): void {
        $this->logEntry = \App\Models\LogEntry::find($logEntryId);
        $this->open = true;
        $this->logEntry->update(['read_at' => now()]);
    }

    public function mount(): void {
        $this->logEntry = new \App\Models\LogEntry();
    }

    public function closeModal(): void {
        $this->open = false;
    }

    public function render() {
        return view('livewire.log-entry');
    }
}
