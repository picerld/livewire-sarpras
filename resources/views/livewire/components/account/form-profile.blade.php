<div aria-labelledby="tab profile">
    <x-form wire:submit="save" no-separator>
        <x-input label="Username" wire:model="newUser.username" autoComplete="off" inline />
        <x-input label="New Password" type="password" wire:model="newUser.password" inline />

        <x-slot:actions>
            <x-button label="Submit" icon="o-paper-airplane" class="text-white btn-primary hover:opacity-80" type="submit"
                spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
