<div class="token">
    <div class="name">
        Tokens
    </div>
    <div class="creation">
        <input type="text" placeholder="Token Name" wire:model="newTokenName" />
        <button wire:click="create" class="button primary">Create Token</button>
    </div>
    <div class="filters">

    </div>
    <div class="entries">
        <table>
            <thead>
            <tr>
                <th style="width: 200px">Name</th>
                <th>Token</th>
                <th style="width: 100px">Created</th>
                <th style="width: 300px">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tokens as $token)
                <tr>
                    <td>{{ $token->name }}</td>
                    <td>{{ $token->token }}</td>
                    <td>{{ $token->created_at->format('Y-m-d') }}</td>
                    <td>
                        <button wire:click="openTokenEditModal({{ $token->id }})"
                                class="button primary">
                            Edit
                        </button>
                        <button wire:click="delete({{ $token->id }})"
                                wire:confirm="Are you sure you want to delete this token?"
                                class="button danger">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @livewire('manage.edit-token')
</div>
