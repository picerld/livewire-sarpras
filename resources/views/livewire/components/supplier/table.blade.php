<x-card>
    <x-header wire:model.live.debounce="search" title="Supplier" class="px-3 pt-3" size="text-3xl" subtitle="Supplier Table"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter item" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="createSuppliersModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create item" />
        </x-slot:actions>
    </x-header>

    <x-table :headers="$headers" :rows="$suppliers" :sort-by="$sortBy" link="/suppliers/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[5, 20, 50]">
        @scope('actions', $suppliers)
            <x-button icon="o-trash" wire:click="delete({{ $suppliers->id }})"
                class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete supplier" spinner />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />

    <x-modal wire:model="createSuppliers" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            <x-form id="suppliersForm" wire:submit.prevent="store" class="space-y-4" autocomplete="off" no-separator>
                <x-input wire:model="newSupplier.name" id="name" label="Name" inline />
                <x-textarea label="Alamat" wire:model="newSupplier.address" placeholder="Type here ..."
                    rows="3" hint="Supplier address" inline />

                <x-slot:actions>
                    <x-button label="Submit!" icon="c-paper-airplane" class="text-white btn-primary" type="submit"
                        spinner="store" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="items" no-separator>
            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" />
            <x-input type="date" label="To Date" wire:model="toDate" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" type="submit" icon="c-paper-airplane"
                    spinner="items" />
            </x-slot:actions>
        </x-form>

    </x-drawer>
</x-card>
