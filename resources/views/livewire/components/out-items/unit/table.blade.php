<x-card class="min-h-[60vh] mx-20">
    <x-header wire:model.live.debounce="search" title="My Items" class="px-3 pt-3" size="text-3xl"
        subtitle="My items transaction" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter submission" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="createRequestModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create submission" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$itemsOut" :sort-by="$sortBy" link="/out-items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[5, 20, 50]">

        @scope('cell_status', $itemsOut)
            <x-badge :value="$itemsOut->status"
                class=" btn-ghost btn-outline {{ $itemsOut->status == 'not taken' ? '' : 'bg-dark text-white' }}" />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="requests" no-separator>
            <!-- User Filter -->
            <x-choices-offline label="Status" wire:model="selectedStatus" :options="$status" searchable single />

            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" />
            <x-input type="date" label="To Date" wire:model="toDate" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" type="submit" icon="c-paper-airplane"
                    spinner="submissions" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</x-card>
