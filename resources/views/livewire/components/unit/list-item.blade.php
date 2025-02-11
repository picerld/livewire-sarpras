<div class="flex flex-col w-full gap-3 mt-10 md:flex-row">
    <div class="w-full mb-6 text-white md:w-1/6 md:mb-0">
        <h3 class="text-lg font-semibold">Kategori</h3>
        <div class="flex flex-row flex-wrap gap-4 mt-3 lg:flex-col md:flex-col lg:flex-nowrap md:flex-nowrap">
            @foreach ($categories as $category)
                <x-checkbox label="{{ $category->aliases }}"
                    class="[--chkbg:theme(colors.indigo.600)] [--chkfg:white] transition-all duration-200 border-none outline-dashed checkbox checked:outline-none"
                    wire:model.live="selectedCategory.{{ $category->id }}" hint="{{ $category->name }}" type="checkbox" />
            @endforeach
        </div>
    </div>

    <div class="flex flex-col w-full">
        <!-- SEARCH BAR -->
        <div class="px-0 mb-4 lg:px-10 md:px-8">
            <!-- WITH DEBOUNCE -->
            {{-- <x-input icon="o-magnifying-glass" placeholder="Search items..." wire:model.live.debounce.500ms="search"
                class="w-full" auto-complete="false" clearable /> --}}

            <x-input icon="o-magnifying-glass" placeholder="Search items..." wire:model.live="search" class="w-full"
                auto-complete="false" clearable />
        </div>

        <div wire:loading wire:target="search">
            <x-loading class="text-white loading-lg" />
        </div>

        <div class="grid grid-cols-1 gap-5 px-0 lg:px-10 md:px-8 lg:grid-cols-4 md:grid-cols-2">
            @forelse ($items as $item)
                <x-card title="{{ $item->name }} ({{ $item->type }})"
                    class="relative flex flex-col justify-between my-2 h-80">
                    <div>
                        <h3 class="text-base font-semibold">
                            {{ $item->stock }} ({{ $item->unit }})
                        </h3>
                        <div class="mb-5">
                            {{ Str::limit($item->description, 40) }}
                        </div>
                    </div>

                    <x-slot:figure>
                        <img src="{{ asset('/storage/' . $item->images) }}" height="200" width="230"
                            class="object-cover w-full h-36" aria-labelledby="{{ $item->id }}"
                            alt="{{ $item->name }}" />
                    </x-slot:figure>

                    <x-badge value="{{ $item->category->aliases ?? 'null' }}"
                        class="absolute text-white right-3 top-2 btn-outline bg-dark" />

                    <div class="w-full mt-3">
                        @auth
                            <div class="flex gap-3">
                                <x-button icon="o-information-circle" class="w-1/3 text-white btn-outline btn-sm bg-dark"
                                    wire:click="detailItemModal({{ $item->id }})" aria-label="detail item" spinner />
                                <x-button icon="o-tag" class="w-2/3 text-white btn-outline btn-sm bg-dark"
                                    wire:click="createCartModal({{ $item->id }})" aria-label="add to cart" spinner />
                            </div>
                        @else
                            <x-button icon="o-information-circle" class="w-full text-white btn-outline btn-sm bg-dark"
                                wire:click="detailItemModal({{ $item->id }})" aria-label="detail item" spinner />
                        @endauth
                    </div>
                </x-card>

            @empty
                <x-alert title="No items found!" description="Try adjusting your search or filters."
                    icon="o-exclamation-triangle" class="border-none bg-base-100 col-span-full">
                    <x-slot:actions>
                        <x-button label="Clear filters" icon="o-x-mark" class="btn-outline" wire:click="clear"
                            spinner />
                    </x-slot:actions>
                </x-alert>
            @endforelse

            <!-- LOAD MORE BUTTON -->
            @if (!$items->isEmpty())
                <div class="flex justify-center col-span-full">
                    @if ($perPage < $maxItems)
                        <x-button class="rounded-full btn-md" label="Load More" wire:click="loadItems('more')" />
                    @else
                        <x-button class="rounded-full btn-md" label="Show Less" wire:click="loadItems('less')" />
                    @endif
                </div>
            @endif
        </div>
    </div>

    <x-modal wire:model="detailItem" class="backdrop-blur" box-class="w-full lg:min-w-[400px] md:min-w-[300px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            @if (isset($itemDetail))
                <x-card title="{{ $itemDetail->name }} ({{ $itemDetail->type }})"
                    class="relative flex flex-col justify-between my-2 h-80">
                    <div>
                        <h3 class="text-base font-semibold">
                            {{ $itemDetail->stock }} ({{ $itemDetail->unit }})
                        </h3>
                        <div class="mb-5">
                            {{ $itemDetail->description }}
                        </div>
                    </div>

                    <x-slot:figure class="min-h-64">
                        @if (isset($itemDetail->images))
                            <img src="{{ asset('/storage/' . $itemDetail->images) }}" height="500" width="230"
                                class="object-cover w-full min-h-full" aria-labelledby="{{ $itemDetail->id }}"
                                alt="{{ $itemDetail->name }}" />
                        @else
                            <div class="flex items-center justify-center w-full bg-gray-100 rounded-lg min-h-64">
                                <x-icon name="o-photo" class="w-20 h-20 text-gray-400" />
                            </div>
                        @endif
                    </x-slot:figure>
                </x-card>
            @endif
        </x-card>
    </x-modal>

    <x-modal wire:model="cartModal" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[300px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            @if (isset($itemDetail))
                {{-- <div class="flex flex-col gap-3 mb-2">
                    <h3 class="text-2xl font-semibold">{{ $itemDetail->name }}</h3>
                </div> --}}
                <div class="flex flex-wrap gap-4 lg:flex-nowrap md:flex-nowrap">
                    <x-card title="{{ $itemDetail->name }} ({{ $itemDetail->type }})"
                        class="relative flex flex-col justify-between w-full my-2 md:w-2/3 lg:w-2/3 h-80">
                        <div>
                            <h3 class="text-base font-semibold">
                                {{ $itemDetail->stock }} ({{ $itemDetail->unit }})
                            </h3>
                            <div class="mb-5">
                                {{ $itemDetail->description }}
                            </div>
                        </div>

                        <x-slot:figure class="min-h-52">
                            @if (isset($itemDetail->images))
                                <img src="{{ asset('/storage/' . $itemDetail->images) }}" height="500" width="230"
                                    class="object-cover w-full min-h-full" aria-labelledby="{{ $itemDetail->id }}"
                                    alt="{{ $itemDetail->name }}" />
                            @else
                                <div class="flex items-center justify-center w-full bg-gray-100 rounded-lg min-h-64">
                                    <x-icon name="o-photo" class="w-20 h-20 text-gray-400" />
                                </div>
                            @endif
                        </x-slot:figure>
                    </x-card>
                    <x-form wire:submit.prevent="cart({{ $itemDetail->id }})"
                        class="flex w-full py-2 lg:w-1/3 md:w-1/3" no-separator>
                        <h2 class="mb-3 text-lg font-semibold">Atur Jumlah</h2>
                        <x-input label="Jumlah" placeholder="1" wire:model="newCart.qty" type="number"
                            min="1"
                            class="transition-all delay-75 border-black outline-none focus:outline-black focus:border-black" />
                        <x-slot:actions>
                            <x-button icon-right="o-arrow-right" label="Add to cart!"
                                class="w-full text-white btn-outline btn bg-dark" type="submit" spinner="cart" />
                        </x-slot:actions>
                    </x-form>
                </div>
            @endif
        </x-card>
    </x-modal>
</div>
