<x-card>
    <x-header wire:model.live.debounce="search" title="Laporan" class="px-3 pt-3" size="text-3xl" subtitle="Items Table"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black focus:border-dark placeholder:font-semibold"
                placeholder="Search..." autocomplete="off" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$items" :sort-by="$sortBy" link='/reports/{id}'
        class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[6, 20, 50]">
        @scope('cell_no', $item)
            {{ $loop->iteration }}
        @endscope

        @scope('cell_category_aliases', $item)
            <x-badge :value="$item->category->aliases ?? 'null'" class="text-white btn-ghost btn-outline bg-dark" />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />
</x-card>
