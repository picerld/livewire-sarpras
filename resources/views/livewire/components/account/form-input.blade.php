<div>
    <x-form id="itemsForm" wire:submit="store" class="space-y-4" autocomplete="off" no-separator>
        <div class="grid grid-cols-1 gap-4">
            <x-choices-offline label="Pegawai" wire:model="newUser.nip" :options="$employees" searchable single />
            <x-choices label="Role" wire:model="newUser.role" :options="$role" single />
            <x-input label="Email" wire:model="newUser.username" inline />
            <x-input label="Password" wire:model="newUser.password" type="password" name="password" inline />
            <x-input label="Confirm Password" wire:model="newUser.confirm_password" name="confirm_password"
                type="password" inline />
        </div>

        <x-slot:actions>
            <x-button label="Submit!" icon="c-paper-airplane" class="text-white btn-primary" type="submit"
                spinner="store" />
        </x-slot:actions>
    </x-form>
</div>
