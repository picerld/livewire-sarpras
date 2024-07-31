<x-card class="min-h-[50vh]">
    <x-header wire:model.live.debounce="search" title="Category" class="px-3 pt-3" size="text-2xl" subtitle="Items category"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass" class="placeholder:font-bold"
                placeholder="Search..." autocomplete="off" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$category" :sort-by="$sortBy" link="/category/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        @scope('actions', $category)
            <x-button icon="o-trash" wire:click="delete({{ $category->id }})" spinner class="btn-sm btn-error btn-outline" />
        @endscope
    </x-table>
</x-card>
