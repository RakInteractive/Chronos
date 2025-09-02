<?php

namespace App\Livewire;

use App\Models\LogEntry as LogEntryModel;
use Livewire\Attributes\On;
use Livewire\Component;

class LogEntry extends Component {
    public LogEntryModel $logEntry;
    public bool $open = false;

    #[On('openLogEntryModal')]
    public function openLogEntryModal(int $logEntryId): void {
        $this->logEntry = LogEntryModel::find($logEntryId);
        $this->open = true;
        $this->logEntry->update(['read_at' => now()]);
    }

    public function mount(): void {
        $this->logEntry = new LogEntryModel();
    }

    public function closeModal(): void {
        $this->open = false;
    }

    public function render() {
        return view('livewire.log-entry');
    }
}
