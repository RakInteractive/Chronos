<?php

namespace App\Livewire\Manage;

use App\Models\Hook;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class HookEntry extends Component {
    public Hook $hook;
    public int $tokenId;
    public string $name;
    public string $type;
    public int $minLevel;
    public bool $enabled;
    public array $config = [];

    public function mount(?int $hookId, int $tokenId): void {
        $this->hook = Hook::find($hookId) ?? new Hook();
        $this->tokenId = $tokenId;
        $this->name = $this->hook->name ?? '';
        $this->type = $this->hook->type ?? 'mail';
        $this->minLevel = $this->hook->min_level ?? 200;
        $this->enabled = $this->hook->enabled ?? true;
        $this->config = $this->hook->config ?? [];
    }

    public function save(): void {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'minLevel' => 'required|int',
            'enabled' => 'boolean',
            'config' => 'array',
        ]);

        $hook = new Hook();

        $hook->token_id = $this->tokenId;
        $hook->name = $this->name;
        $hook->type = $this->type;
        $hook->min_level = $this->minLevel;
        $hook->enabled = $this->enabled;
        $hook->config = $this->config;

        $hook->save();

        $this->tokenId = 0;
        $this->name = '';
        $this->type = 'mail';
        $this->minLevel = 200;
        $this->enabled = true;
        $this->config = [];

        $this->dispatch('refresh');
    }

    public function delete(): void {
        $this->hook->delete();
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render(): View {
        return view('livewire.manage.hook-entry')->with('hookId', $this->hook?->id ?? 0);
    }
}
