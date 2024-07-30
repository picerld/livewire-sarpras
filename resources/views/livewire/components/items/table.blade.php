<x-card>
    <x-header wire:model.live.debounce="search" title="Barang" class="px-3 pt-3" size="text-2xl" subtitle="Items Table"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass" class="placeholder:font-bold"
                placeholder="Search..." autocomplete="off" />
            <x-button icon="o-funnel" label="Filters" badge="0" wire:click="tableDrawer" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="createItemsModal"
                class="text-white btn-primary hover:opacity-80" responsive aria-label="create item" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$items" :sort-by="$sortBy" link="/items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        @scope('cell_category_name', $item)
            <x-badge :value="$item->category->name" class="text-white badge-primary" />
        @endscope
    </x-table>

    <x-spotlight />

    <x-modal wire:model="createItems" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            <x-form id="itemsForm" wire:submit="store" class="space-y-4" autocomplete="off" no-separator>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-input wire:model="newItem.name" id="name" label="Name" inline />
                    <x-input wire:model="newItem.merk" id="merk" label="Merk" inline />
                    <x-input wire:model="newItem.unit" id="unit" label="Satuan" inline />
                    <x-input label="Price" wire:model="newItem.price" suffix="Rp" money locale="id-ID" inline />
                    <x-input wire:model="newItem.stock" id="stock" type="number" label="Stok" min="1"
                        inline />
                    <x-input wire:model="newItem.minimum_stock" id="minimum_stock" label="Stok minimum" type="number"
                        min="1" inline />
                    <x-select wire:model="newItem.category_id" id="category" for="Category" label="Category"
                        :options="$categories" inline />
                    <x-file wire:model="newItem.images" accept="image/png" crop-after-change />
                </div>
                <x-textarea label="Deskripsi" wire:model="newItem.description" placeholder="Type here ..."
                    rows="3" inline />

                <x-slot:actions>
                    <x-button label="Submit!" icon="c-paper-airplane" class="text-white btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="items" no-separator>
            <!-- Category Filter -->
            <x-choices label="Category" wire:model="selectedCategory" :options="$categories" inline single />

            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" />
            <x-input type="date" label="To Date" wire:model="toDate" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" type="submit" icon="c-paper-airplane" spinner="save" />
            </x-slot:actions>
        </x-form>

    </x-drawer>
</x-card>