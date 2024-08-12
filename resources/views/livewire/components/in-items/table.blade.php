<x-card class="min-h-[70vh]">
    <x-header wire:model.live.debounce="search" title="Barang Masuk" class="px-3 pt-3" size="text-3xl" subtitle="Items Table"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                placeholder="Search..." autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter item" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="createItemsModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create item" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$itemsIn" :sort-by="$sortBy" link="/in-items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        @scope('actions', $itemsIn)
            <x-button icon="o-trash" wire:click="delete({{ $itemsIn->id }})"
                class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
        @endscope
    </x-table>

    <x-spotlight />

    <x-modal wire:model="createItems" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            <livewire:components.in-items.form-item-in />
        </x-card>
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="itemsIn" no-separator>
            <!-- User Filter -->
            <x-choices-offline label="User" wire:model="selectedUser" :options="$users" searchable inline single />
            <x-choices-offline label="Supplier" wire:model="selectedSupplier" :options="$suppliers" searchable inline
                single />

            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" />
            <x-input type="date" label="To Date" wire:model="toDate" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" icon="c-paper-airplane" type="submit"
                    spinner="itemsIn" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</x-card>
