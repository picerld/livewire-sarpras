<div>
    <!-- FIX THIS UI!!!!! -->

    <x-button label="Go back!" link="/in-items" icon="c-arrow-left-start-on-rectangle"
        class="w-28 btn-outline btn-sm" spinner />
    <div class="flex flex-wrap w-full mt-6">
        @forelse ($items as $item)
            <div class="flex w-full p-2 md:w-1/3 lg:1/4">
                <x-card title="{{ $item->item->name }}">
                    <h3 class="text-lg font-semibold">
                        ({{ $item->qty }} {{ $item->item->unit }})
                    </h3>
                    <div class="overflow-y-auto max-h-20 min-h-20 text-balance">
                        {{ $item->item->description }}
                    </div>
                    <p class="text-sm font-semibold">
                        {{ $item->created_at }}
                    </p>

                    <x-slot:figure>
                        <img src="{{ asset('/storage/' . $item->item->images) }}" height="200" width="230"
                            class="object-cover w-full min-h-40 max-h-40" aria-labelledby="{{ $item->item->id }}"
                            alt="{{ $item->item->name }}" />
                    </x-slot:figure>
                    <x-slot:menu>
                        <x-badge value="{{ $item->item->category->name }}" class="text-white badge-primary badge-lg" />
                    </x-slot:menu>
                    <div class="mt-3">
                        <x-button icon="o-document-minus"
                            wire:click="delete({{ $item->item->id }}, {{ $item->incoming_item_id }})"
                            label="Remove Item" class="btn-outline btn-ghost btn-sm" spinner aria-label="delete item" />
                    </div>
                </x-card>
            </div>
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
