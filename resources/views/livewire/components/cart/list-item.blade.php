<div class="flex flex-col gap-3 px-10 lg:flex-row">
    <!-- Main content area -->
    <div class="flex flex-col w-full gap-5 mt-5 lg:w-2/3">
        <div class="flex items-center justify-between p-5 border rounded-lg bg-base-100 dark:border-none">
            <div class="flex gap-3">
                <input id="pilih-semua" aria-label="Check all"
                    class="transition-all duration-200 border-none checkbox checkbox-sm outline-dashed checked:outline-none"
                    type="checkbox" {{ $countCheckedItems == $items->count() ? 'checked' : '' }} wire:click="checkAll">
                <label for="pilih-semua" class="text-sm font-bold cursor-pointer">
                    Pilih Semua ({{ $items->count() }})
                </label>
            </div>
            {{-- <x-button label="Hapus" class="text-sm font-bold text-black btn-link" /> --}}
        </div>

        <!-- Items list -->
        @forelse ($items as $unit)
            <div aria-label="Card" class="border border-t-0 dark:border-none card bg-base-100">
                <div class="p-0 card-body">
                    <div class="flex flex-col w-full gap-3 lg:flex-row">
                        <div class="flex flex-col w-full gap-3 m-5 md:flex-row">
                            <input aria-label="Check all"
                                class="transition-all duration-200 border-none checkbox checkbox-sm outline-dashed checked:outline-none"
                                type="checkbox" wire:model.live="checkedItems.{{ $unit->item->id }}">
                            <div class="flex w-full lg:w-4/5 md:w-4/5">
                                <div class="flex-shrink-0 size-16">
                                    @if (isset($unit->item->images))
                                        <img src="{{ asset('storage/' . $unit->item->images) }}"
                                            class="object-cover w-full h-full rounded-md" alt="{{ $unit->item->name }}">
                                    @else
                                        <div class="flex items-center justify-center bg-white rounded-lg w-fit h-fit">
                                            <x-icon name="o-photo" class="w-11 h-11 text-dark/90" />
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h1 class="text-base font-semibold">{{ $unit->item->name }} {{ $unit->item->type }}
                                        {{ $unit->qty }}
                                        ({{ $unit->item->unit }})
                                    </h1>
                                    <p class="text-sm">
                                        {{ $unit->item->merk }},
                                        @currency($unit->item->price)
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-end w-full mt-4 mr-8 lg:w-1/5 md:w-1/5 lg:mt-0">
                                <div class="flex gap-2">
                                    <!-- REMOVE BUTTON -->
                                    <x-button class="btn-outline btn-sm join-item" icon="o-trash"
                                        wire:click.prevent="delete({{ $unit->id }})" spinner />
                                    <div class="border join join-horizontal border-dark">
                                        <!-- MINUS BUTTON -->
                                        <x-button wire:click.prevent="decrement({{ $unit->id }})" icon="m-minus"
                                            class="join-item btn-sm btn-ghost" />
                                        <button
                                            class="px-3 font-semibold normal-case border-none btn border-base-content/20 md:flex btn-sm btn-ghost join-item">{{ $unit->qty }}</button>
                                        <!-- PLUS BUTTON -->
                                        <x-button wire:click.prevent="increment({{ $unit->id }})" icon="m-plus"
                                            class="join-item btn-sm btn-ghost" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        @endforelse
    </div>

    <!-- Perihal (Confirmation) section -->
    <div class="relative w-full mt-3 lg:mt-5 lg:ml-2 lg:w-1/3">
        <div aria-label="card" class="p-5 border rounded-lg shadow-lg bg-base-100 dark:border-none lg:sticky lg:top-24">
            <div class="flex flex-col gap-2">
                <h1 class="text-xl font-semibold">Ringkasan pengadaan</h1>
                <div class="flex flex-wrap justify-between">
                    <p class="text-sm">Total items</p>
                    <div class="flex gap-3">
                        @foreach ($totalQtyByUnit as $data)
                            <div class="flex flex-col gap-2">
                                <p class="text-sm font-bold">{{ $data['unit'] }}</p>
                                <p class="text-sm font-semibold">{{ $data['total'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="my-3">
            </div>
            <x-form wire:submit.prevent="store">
                <div class="flex flex-col">
                    <label class="w-full py-2 form-control">
                        <x-textarea label="Perihal" wire:model="regarding" placeholder="Type here ..."
                            hint="Max 200 chars" rows="5"
                            class="transition-all duration-200 border-none outline-dashed focus:outline-dark" />
                    </label>
                </div>
                @if ($countCheckedItems > 0)
                    <x-button label="Kirim ({{ $countCheckedItems }})" type="submit" spinner="store"
                        class="items-center w-full text-white btn-outline bg-dark" />
                @endif
            </x-form>
        </div>
    </div>
</div>
