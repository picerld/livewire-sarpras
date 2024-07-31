<div>
    <x-button label="Go back!" link="/in-items" icon="c-arrow-left-start-on-rectangle" class="w-32 btn-outline" spinner />
    <div class="grid w-full grid-cols-1 gap-4 mt-4">
        @forelse ($items as $item)
            <div class="grid w-full gap-4 border border-gray-400 border-dashed rounded-md md:items-center">
                <x-card title="{{ $item->item->name }} ({{ $item->qty }} {{ $item->item->unit }})">
                    {{ $item->item->description }}

                    <x-slot:menu>
                        <x-badge value="{{ $item->item->category->name }}" class="text-white badge-primary badge-lg" />
                    </x-slot:menu>
                    <div class="mt-3">
                        <x-button icon="o-trash"
                            wire:click="delete({{ $item->item->id }}, {{ $item->incoming_item_id }})" label="Delete"
                            class="btn-outline btn-error btn-sm" spinner aria-label="delete item" />
                    </div>
                </x-card>
            </div>
        @empty
            <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
                <x-slot:actions>
                    <x-button label="Go back!" link="/in-items" icon="o-x-mark" class="btn-outline" spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </div>
</div>
