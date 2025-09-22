<div class="addons">
    @forelse($addons as $addon)
        <div class="card">
            <div class="card-header">
                <h3>{{ $addon->metadata['name'] ?? $addon->slug }}</h3>
            </div>
            <div class="card-body">
                <p>{{ $addon->metadata['author'] ?? 'Unknown Author' }}</p>
                <p>{{ $addon->metadata['version'] ?? 'Unknown Version' }}</p>
                <p>{{ $addon->metadata['description'] ?? '' }}</p>
            </div>
            <div class="card-footer">
                <div>{{ $addon->enabled ? 'Enabled' : 'Disabled' }}</div>
                <button wire:click="toggleAddon({{ $addon->id }}, {{ $addon->enabled ? 0 : 1 }})"
                        class="button {{ $addon->enabled ? 'danger' : 'secondary' }}">
                    {{ $addon->enabled ? 'Disable' : 'Enable' }}
                </button>
            </div>
        </div>
    @empty
        <p>No addons found.</p>
    @endforelse
</div>
