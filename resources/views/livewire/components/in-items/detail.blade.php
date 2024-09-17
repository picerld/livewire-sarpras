<div class="min-h-[85vh]">
    <!-- FIX THIS UI!!!!! -->

    <x-button label="See all items" link="/in-items" icon="c-chevron-left" class="text-sm text-white bg-dark btn-outline btn-sm" spinner />
    <div class="grid w-full grid-cols-1 gap-4 py-3 md:grid-cols-3 lg:grid-cols-3">
        @forelse ($items as $item)
        <x-card title="{{ $item->item->name }} ({{ $item->item->type }})" class="my-2">
            <h3 class="text-base font-semibold">
                ({{ $item->qty }} {{ $item->item->unit }})
            </h3>
            <div class="mb-5">
                @if (Str::length($item->item->description) > 20)
                    {{ Str::limit($item->item->description, 20) }}
                @else
                    {{ $item->item->description }}
                @endif
            </div>
            <p class="text-sm font-semibold">
                {{ $item->created_at->format('H:i:s d/m/Y') }}
            </p>
            <p class="text-sm font-normal">
                {{ $item->created_at->diffForHumans() }}
            </p>
    
            <x-slot:figure>
                <img src="{{ asset('/storage/' . $item->item->images) }}" height="200" width="230"
                    class="object-cover w-full min-h-40 max-h-40" aria-labelledby="{{ $item->item->id }}"
                    alt="{{ $item->item->name }}" />
            </x-slot:figure>
            <x-slot:menu>
                <x-badge value="{{ $item->item->category->aliases ?? 'null' }}" class="btn-ghost btn-outline" />
            </x-slot:menu>
            <div class="w-full mt-3">
                <x-button icon="o-wrench-screwdriver"
                    wire:click="delete({{ $item->item->id }}, {{ $item->incoming_item_code }})" label="Remove"
                    class="w-full btn-outline btn-ghost btn-sm" spinner aria-label="delete item" />
            </div>
        </x-card>
    
        @empty
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
                <x-slot:actions>
                    <x-button label="Clear!" link="/in-items" icon="o-x-mark" class="btn-outline" spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </div>
    
</div>
