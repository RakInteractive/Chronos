<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ $title ?? 'Title' }}</title>
    @livewireStyles
</head>
<body>
@if(auth()->check())
    <nav>
        <div class="sidebar">
            <div>
                <div class="top">
                    <p class="border-b-black"><a href="{{ route('dashboard') }}">Dashboard</a></p>
                    <hr>
                    @foreach(\App\Models\Token::orderBy('name')->get() as $token)
                        <p><a href="{{ route('token', $token->id) }}">
                                @if($token->unreadLogEntries()->count() > 0)
                                    <span class="badge">{{ $token->unreadLogEntries()->count() }}</span>
                                @endif
                                {{ $token->name }}</a>
                        </p>
                    @endforeach
                </div>
                <div class="bottom">
                    <hr>
                    <p><a href="{{ route('manage.tokens') }}">Token</a></p>
                    <p><a href="#">Accounts</a></p>
                    <p><a href="#">Profile</a></p>
                    <hr>
                    <p><a href="{{ route('logout') }}">Logout</a></p>
                    <hr>
                    <p class="text-center"><a href="https://rak-interactive.com" target="_blank">&copy; Rak Interactive {{ date('Y') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </nav>
@endif
<div class="content {{ auth()->check() ? 'authenticated' : '' }}">
    {{ $slot }}
</div>
@livewireScripts
</body>
</html>
