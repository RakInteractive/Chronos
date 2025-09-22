<?php

namespace App\Livewire\Manage;

use App\Models\Addon;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Addons extends Component {
    #[On('refresh')]
    public function render(): View {
        return view('livewire.manage.addons')
            ->with('addons', Addon::all()->append('metadata'));
    }

    public function toggleAddon(int $addonId, bool $value): void {
        $addon = Addon::find($addonId);

        if ($addon) {
            $addon->enabled = $value;
            $addon->save();
            $this->dispatch('refresh');
        }
    }
}
