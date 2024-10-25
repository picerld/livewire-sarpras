<x-card class="shadow">
    <x-header wire:model.live.debounce="search" title="Item Overview" subtitle="Item with minimum stock!" class="px-3 pt-3" separator
        progress-indicator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
        </x-slot:actions>
    </x-header>
    <div class="bg-white rounded dark:bg-dark">
        @forelse ($items as $item)
            <x-list-item :item="$item" :link="url('/items/' . $item->id)">
                <x-slot:avatar>
                    <img src="{{ $item->images ? asset('/storage/' . $item->images) : asset('img/submission.webp') }}"
                        width="44" height="44" alt="{{ $item->name }}" class="rounded-full w-11 avatar" />
                </x-slot:avatar>
                <x-slot:value>
                    {{ $item->name }} {{ $item->type }}
                    <x-badge :value="$item->category_aliases" class="btn-ghost btn-outline" />
                </x-slot:value>
                <x-slot:sub-value>
                    <div class="flex gap-1">
                        <p class="text-black">
                            {{ $item->stock }} {{ $item->unit }}
                        </p>
                        <p class="font-semibold text-black">
                            ({{ $item->minimum_stock }})
                        </p>
                    </div>
                </x-slot:sub-value>
            </x-list-item>
        @empty
            <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
                <x-slot:actions>
                    <x-button label="Clear filters" wire:click="clear" icon="o-x-mark" class="btn-outline" spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </div>
</x-card>
