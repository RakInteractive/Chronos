<div class="token">
    {{-- Success is as dangerous as failure. --}}
    <div class="name">
        {{ $token->name }}
    </div>
    <div class="filters">

    </div>
    <div class="entries">
        <table>
            <thead>
            <tr>
                <th style="width: 200px">Received</th>
                <th>Title</th>
                <th style="width: 100px">Level</th>
                <th style="width: 300px">Labels</th>
            </tr>
            </thead>
            <tbody>
            @foreach($token->logEntries()->orderBy('created_at', 'desc')->get() as $entry)
                <tr class="@if($entry->read_at == null) unread @endif" wire:click="openLogEntryModal({{ $entry->id }})">
                    <td>{{ $entry->created_at->format('H:i:s d.m.Y') }}</td>
                    <td>{{ $entry->title }}</td>
                    <td>{{ $entry->level }}</td>
                    <td class="labels">@foreach(array_slice($entry->labels ?? [], 0, 3) as $label)
                            <p class="label">{{ $label }}</p>
                        @endforeach</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @livewire('log-entry')
</div>
