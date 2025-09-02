<div x-data="{ open: @entangle('open') }">
    @if($token)
        <div x-show="open" class="modal">
            <div class="m-content">
                <div class="m-header">
                    <h2>Edit Token</h2>
                </div>
                <div class="m-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" wire:model="name" required>
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <hr/>
                        <div class="hooks">
                            <p>Hooks</p>
                            {{-- new hook --}}
                            <livewire:manage.hook-entry
                                :key="'new-'.$token->id"
                                :hook-id="null"
                                :token-id="$token->id"
                            />

                            {{-- existing hooks --}}
                            @foreach($hooks as $hook)
                                <livewire:manage.hook-entry
                                    :key="$hook['id']"
                                    :hook-id="$hook['id']"
                                    :token-id="$token->id"
                                />
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="m-footer">
                    <button wire:click="save" class="button primary">Save</button>
                    <button wire:click="closeModal" class="close-button">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
