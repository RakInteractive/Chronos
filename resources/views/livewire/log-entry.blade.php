<div x-data="{ open: @entangle('open') }">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div x-show="open" class="modal">
        <div class="m-content">
            <h2 class="mb-5"><span class="level-{{ $logEntry?->level }} text-lg">
                    {{ $logEntry?->level }}
                </span>
                {{ $logEntry?->title ?? '' }}
            </h2>
            <div>
                Received: <span class="font-bold">{{ $logEntry?->created_at?->format('d.m.Y H:i:s') }}</span>
            </div>
            <div>
                <h3>Labels: </h3>
                <div class="labels my-2">
                    @foreach($logEntry?->labels ?? [] as $label)
                        <p class="label">{{ $label }}</p>
                    @endforeach
                </div>
            </div>
            <div>
                <h3>Content:</h3>
                <pre>{{ json_encode(json_decode($logEntry?->content ?? '', true), JSON_PRETTY_PRINT) }}</pre>
            </div>
            <div>
                <h3>Context:</h3>
                <pre>{{ json_encode($logEntry?->context ?? [], JSON_PRETTY_PRINT) }}</pre>
            </div>
            <button wire:click="closeModal" class="close-button">Close</button>
        </div>
    </div>
</div>
