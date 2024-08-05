<div>
    <x-form id="itemsForm" wire:submit="store" class="space-y-4" autocomplete="off" no-separator>
        <div class="grid grid-cols-1 gap-4">
            <x-input wire:model="newUser.name" id="name" label="nama" inline />
        </div>
        <x-textarea label="Deskripsi" wire:model="newItem.description" placeholder="Type here ..." rows="3"
            inline />

        <x-slot:actions>
            <x-button label="Submit!" icon="c-paper-airplane" class="text-white btn-primary" type="submit"
                spinner="store" />
        </x-slot:actions>
    </x-form>
</div>
