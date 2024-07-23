<x-card>
    <x-header wire:model.live.debounce="search" title="Barang" subtitle="Barang Model" class="px-3 pt-3" progress-indicator
        separator>
        <x-slot:actions>
            <x-input wire:model="search" icon="o-magnifying-glass" class="placeholder:font-bold" placeholder="Search..." />
            <x-button icon="o-funnel" label="Filters" badge="0" wire:click="tableDrawer" responsive />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$items" :sort-by="$sortBy" link="/items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        @scope('actions', $items)
            <x-button icon="o-trash" @click="$wire.deleteModal = true" class="btn-sm" />
        @endscope
        {{-- @empty($rows)
            <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
                <x-slot:actions>
                    <x-button label="Clear filters" wire:click="clear" icon="o-x-mark" class="btn-outline" spinner />
                </x-slot:actions>
            </x-alert>
        @endempty --}}
    </x-table>

    <x-spotlight />

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="users" no-separator>
            {{-- wire:model="name" --}}
            <x-input label="Role" inline />

            <x-slot:actions>
                <x-button label="Cancel" class="btn btn-ghost btn-outline" />
                <x-button label="Click me!" class="text-white btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-drawer>

    <x-modal wire:model="deleteModal" title="Are your sure?" subtitle="Livewire example" class="backdrop-blur">
        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.deleteModal = false" />
            <x-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>
</x-card>
