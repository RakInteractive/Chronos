<div>
    <div class="form-row">
        <div class="form-group">
            <label for="enabled-{{ $hookId }}">Enabled</label>
            <input type="checkbox" id="enabled-{{ $hookId }}" wire:model="enabled" required>
            @error('enabled') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="name-{{ $hookId }}">Name</label>
            <input type="text" id="name-{{ $hookId }}" wire:model="name" required>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="type-{{ $hookId }}">Type</label>
            <select id="type-{{ $hookId }}" wire:model.live="type" required>
                <option value="mail">Mail</option>
                <option value="teams">Teams</option>
                @if(config('chronos.pushover.token', false)) <option value="pushover">Pushover</option> @endif
            </select>
            @error('type') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="min_level-{{ $hookId }}">Min Level</label>
            <select id="min_level-{{ $hookId }}" wire:model="minLevel" required>
                <option value="100">Debug</option>
                <option value="200">Info</option>
                <option value="250">Notice</option>
                <option value="300">Warning</option>
                <option value="400">Error</option>
                <option value="500">Critical</option>
                <option value="550">Alert</option>
                <option value="600">Emergency</option>
            </select>
            @error('min_level') <span class="error">{{ $message }}</span> @enderror
        </div>
    </div>
    @switch($type)
        @case('mail')
            <div class="form-row">
                <div class="form-group">
                    <label for="config-email-{{ $hookId }}">Recipient Email</label>
                    <input type="email" id="config-email-{{ $hookId }}" wire:model="config.email" required>
                    @error('config.email') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        @break
        @case('teams')
            <div class="form-row">
                <div class="form-group">
                    <label for="config-webhook-url-{{ $hookId }}">Webhook URL</label>
                    <input type="url" id="config-webhook-url-{{ $hookId }}" wire:model="config.url" required>
                    @error('config.url') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        @break
        @case('pushover')
            <div class="form-row">
                <div class="form-group">
                    <label for="config-user-{{ $hookId }}">User/Group Key</label>
                    <input type="text" id="config-user-{{ $hookId }}" wire:model="config.user" required>
                    @error('config.user') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="config-sound-{{ $hookId }}">Sound</label>
                    <select id="config-sound-{{ $hookId }}" wire:model="config.sound">
                        <option value="pushover">Pushover (default)</option>
                        <option value="bike">Bike</option>
                        <option value="bugle">Bugle</option>
                        <option value="cashregister">Cash Register</option>
                        <option value="classical">Classical</option>
                        <option value="cosmic">Cosmic</option>
                        <option value="falling">Falling</option>
                        <option value="gamelan">Gamelan</option>
                        <option value="incoming">Incoming</option>
                        <option value="intermission">Intermission</option>
                        <option value="magic">Magic</option>
                        <option value="mechanical">Mechanical</option>
                        <option value="pianobar">Piano Bar</option>
                        <option value="siren">Siren</option>
                        <option value="spacealarm">Space Alarm</option>
                        <option value="tugboat">Tug Boat</option>
                        <option value="alien">Alien Alarm (long)</option>
                        <option value="climb">Climb (long)</option>
                        <option value="persistent">Persistent (long)</option>
                        <option value="echo">Pushover Echo (long)</option>
                        <option value="updown">Up Down (long)</option>
                        <option value="vibrate">Vibrate Only</option>
                        <option value="none">None (silent)</option>
                    </select>
                    @error('config.sound') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        @break
        @default
            <div class="form-row">
                <div class="form-group">
                    <label for="config-{{ $hookId }}">Config (JSON)</label>
                    <textarea id="config-{{ $hookId }}" wire:model="config" required></textarea>
                    @error('config') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
    @endswitch
    <div class="form-row">
        <button type="button" wire:click="save" class="button primary">Save Hook</button>
        @if($hook->id)
            <button type="button" wire:click="delete" class="button danger">Delete Hook</button>
        @endif
    </div>
</div>
