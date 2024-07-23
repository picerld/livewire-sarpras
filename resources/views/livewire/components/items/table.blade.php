<x-card>
    <x-header wire:model.live.debounce="search" title="Barang" class="px-3 pt-3" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" icon="o-magnifying-glass" class="placeholder:font-bold" placeholder="Search..." />
            <x-button icon="o-funnel" label="Filters" badge="0" wire:click="tableDrawer" responsive />
            <x-button icon-right="m-plus" label="Add" link="{{ route('items.create') }}"
                class="text-white btn-primary hover:opacity-80" responsive aria-label="create item" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$items" :sort-by="$sortBy" link="/items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        @scope('cell_category.name', $item)
            <x-badge :value="$item->category->name" class="text-white badge-primary" />
        @endscope
        
        @scope('actions', $item)
            <x-button icon="o-trash" wire:click="delete({{ $item->id }})" class="btn-sm text-error" spinner aria-label="delete item" />
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
        <x-form wire:submit="items" no-separator>
            <!-- Category Filter -->
            <x-select label="Category" wire:model="selectedCategory" :options="$categories" inline />

            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" inline />
            <x-input type="date" label="To Date" wire:model="toDate" inline />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</x-card>