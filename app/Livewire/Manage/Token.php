<?php

namespace App\Livewire\Manage;

use App\Models\Token as TokenModel;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Token extends Component {
    public string $newTokenName = '';

    #[On('refresh')]
	public function render(): View {
		return view('livewire.manage.token')
            ->with('tokens', TokenModel::all());
	}

    public function create(): void {
        $this->validate([
            'newTokenName' => ['required', 'string', 'max:255'],
        ]);

        TokenModel::create([
            'name' => $this->newTokenName,
            'token' => Str::uuid()->toString(),
        ]);

        $this->newTokenName = '';
        $this->dispatch('refresh');
    }

    public function openTokenEditModal(int $tokenId): void {
        $this->dispatch('openTokenEditModal', $tokenId);
    }

    public function delete(int $tokenId): void {
        TokenModel::find($tokenId)?->delete();
        $this->dispatch('refresh');
    }
}
