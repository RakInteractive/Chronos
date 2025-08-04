<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component {
    #[Validate('required|email')]
    public $email;
    #[Validate('required')]
    public $password;

    public function login() {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->to('/dashboard');
        } else {
            session()->flash('error', 'Invalid email or password');
        }
    }

    public function mount() {
        if (auth()->check()) {
            return redirect()->to('/dashboard');
        }
    }

    public function render() {
        return view('livewire.login');
    }
}
