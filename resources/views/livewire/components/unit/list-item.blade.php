<div class="flex flex-col w-full gap-3 mt-10 md:flex-row">
    <div class="w-full mb-6 text-white md:w-1/6 md:mb-0">
        <h3 class="text-lg font-semibold">Kategori</h3>
        <div class="mt-3">
            <label class="flex items-center gap-3">
                <input type="checkbox" class="transition-all duration-200 outline-dashed checkbox checked:outline-none">
                <h2 class="font-medium">ATK</h2>
            </label>
            <label class="flex items-center gap-3 mt-3">
                <input type="checkbox" class="transition-all duration-200 outline-dashed checkbox checked:outline-none">
                <h2 class="font-medium">Bangunan</h2>
            </label>
            <label class="flex items-center gap-3 mt-3">
                <input type="checkbox" class="transition-all duration-200 outline-dashed checkbox checked:outline-none">
                <h2 class="font-medium">Kebersihan</h2>
            </label>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 px-10 lg:grid-cols-4 md:grid-cols-2">
        @forelse ($items as $item)
            <x-card title="{{ $item->name }} ({{ $item->type }})" class="flex flex-col justify-between my-2 h-80">
                <div>
                    <h3 class="text-base font-semibold">
                        {{ $item->stock }} ({{ $item->unit }})
                    </h3>
                    <div class="mb-5">
                        @if (Str::length($item->description) > 40)
                            {{ Str::limit($item->description, 40) }}
                        @else
                            {{ $item->description }}
                        @endif
                    </div>
                </div>

                <x-slot:figure>
                    <img src="{{ asset('/storage/' . $item->images) }}" height="200" width="230"
                        class="object-cover w-full min-h-32 max-h-32" aria-labelledby="{{ $item->id }}"
                        alt="{{ $item->name }}" />
                </x-slot:figure>

                <x-slot:menu>
                    <x-badge value="{{ $item->category->aliases ?? 'null' }}" class="text-white btn-outline bg-dark" />
                </x-slot:menu>

                <div class="w-full mt-3">
                    @auth
                        <div class="flex gap-3">
                            <x-button icon="o-information-circle" class="w-1/3 text-white btn-outline btn-sm bg-dark"
                                wire:click="detailItemModal({{ $item->id }})" spinner />
                            <x-button icon="o-tag" class="w-2/3 text-white btn-outline btn-sm bg-dark"
                                wire:click="createCartModal({{ $item->id }})" spinner />
                        </div>
                    @else
                        <x-button icon="o-information-circle" class="w-full text-white btn-outline btn-sm bg-dark"
                            wire:click="detailItemModal({{ $item->id }})" spinner />
                    @endauth
                </div>
            </x-card>

        @empty
            <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
                <x-slot:actions>
                    <x-button label="Clear filters" icon="o-x-mark" class="btn-outline" spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </div>

    <x-modal wire:model="detailItem" class="backdrop-blur" box-class="w-full lg:min-w-[400px] md:min-w-[300px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            @if (isset($itemDetail))
                <div class="flex flex-col">
                    <p>
                        {{ $itemDetail->name }}
                    </p>
                    <p>
                        {{ $itemDetail->stock }} {{ $itemDetail->unit }}
                    </p>
                </div>
            @endif
        </x-card>
    </x-modal>

    <x-modal wire:model="cartModal" class="backdrop-blur" box-class="w-full lg:min-w-[400px] md:min-w-[300px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            @if (isset($itemDetail))
                <div class="flex flex-col gap-3 mb-2">
                    <h3 class="text-2xl font-semibold">{{ $itemDetail->name }}</h3>
                </div>
                <x-form wire:submit.prevent="cart" no-separator>
                    <x-input label="Quantity" wire:model="newCart.qty" icon="o-user" inline />
                </x-form>

                <x-slot:actions>
                    <x-button label="Add to cart!" class="text-white btn-primary hover:opacity-80" type="submit"
                        spinner="cart" wire:click="cart({{ $itemDetail->id }})" />
                </x-slot:actions>
            @endif
        </x-card>
    </x-modal>
</div>
