<x-card class="min-h-[50vh]">
    <x-header wire:model.live.debounce="search" title="Category" class="px-3 pt-3" size="text-2xl" subtitle="Category items"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                placeholder="Search..." autocomplete="off" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$category" :sort-by="$sortBy" link="/category/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        @scope('actions', $category)
            <x-button icon="o-trash" wire:click="delete({{ $category->id }})" aria-label="delete category" spinner
                class="btn-sm btn-ghost btn-outline" />
        @endscope
    </x-table>
</x-card>
