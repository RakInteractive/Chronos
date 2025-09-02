<?php

namespace App\Livewire\Manage;

use App\Models\Token as TokenModel;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class EditToken extends Component {
    public ?TokenModel $token;
    public bool $open = false;

    public string $name = '';

    public array $hooks = [];

    #[On('openTokenEditModal')]
    public function openTokenEditModal(int $tokenId): void {
        $this->token = TokenModel::find($tokenId);
        $this->name = $this->token->name;

        foreach ($this->token->hooks as $hook) {
            $this->hooks[] = [
                'id' => $hook->id,
                'name' => $hook->name,
                'type' => $hook->type,
                'min_level' => $hook->min_level,
                'enabled' => $hook->enabled,
                'config' => $hook->config,
            ];
        }

        $this->open = true;
    }

    public function save(): void {
        $this->validate(['name' => 'required|string|max:255']);

        if ($this->token) {
            $this->token->name = $this->name;
            $this->token->save();
        }

        $this->closeModal();
        $this->dispatch('refresh');
    }

    public function closeModal(): void {
        $this->open = false;
    }

    #[On('refresh')]
    public function render(): View {
        return view('livewire.manage.edit-token');
    }
}
