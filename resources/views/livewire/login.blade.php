<div class="login">
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <form wire:submit.prevent="login">
        @if (session()->has('error'))
        <div class="error">
                <span>{{ session('error') }}</span>
        </div>
        @endif
        <div class="field">
            <label for="email">Email</label>
            <input type="email" wire:model="email" id="email" aria-describedby="emailHelp">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" wire:model="password" id="password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit">Login</button>
    </form>
</div>
