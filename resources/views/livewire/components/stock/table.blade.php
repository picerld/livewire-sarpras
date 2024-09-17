<x-card>
    <x-header wire:model.live.debounce="search" title="Barang" class="px-3 pt-3" size="text-3xl" subtitle="Items Table"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter item" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="createItemsModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create item" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$stock" :sort-by="$sortBy" link="/items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        {{-- @foreach ($incoming_stock as $i_stock)
            @scope('cell_stok_barang_masuk', $stock, $i_stock)
                {{ $i_stock->qty }}
            @endscope
        @endforeach --}}
    </x-table>

    <x-spotlight />

</x-card>
