<div class="dashboard">
    {{-- Be like water. --}}
    @foreach($tokens as $token)
        <div class="card">
            <div class="card-header">
                <h3>{{ $token->name }}</h3>
            </div>
            <div class="card-body">
                <p>{{ $token->unreadLogEntries()->count() }} unread log entries</p>
                @if($token->criticalLogEntries()->count() > 0)
                    <p class="text-red-500">{{ $token->criticalLogEntries()->count() }} entries need attention!</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('token', ['token' => $token->id]) }}">Details</a>
            </div>
        </div>
    @endforeach
</div>
