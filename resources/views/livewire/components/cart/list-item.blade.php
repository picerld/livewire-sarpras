<div class="flex flex-col gap-3 px-10 lg:flex-row">
    <!-- Main content area -->
    <div class="flex flex-col w-full gap-5 mt-5 lg:w-2/3">
        <!-- Header with select all and delete button -->
        <div class="flex justify-between p-5 border rounded-lg bg-base-100 dark:border-none">
            <div class="flex gap-3">
                <input id="pilih-semua" aria-label="Check all"
                    class="transition-all duration-200 border-none checkbox checkbox-sm outline-dashed checked:outline-none"
                    type="checkbox">
                <label for="pilih-semua" class="text-sm font-bold">Pilih Semua ({{ $items->count() }})</label>
            </div>
            <button class="text-sm font-bold text-black">Hapus</button>
        </div>

        <!-- Items list -->
        @forelse ($items as $unit)
            <div aria-label="Card" class="border border-t-0 dark:border-none card bg-base-100">
                <div class="p-0 card-body">
                    <div class="flex flex-col w-full gap-4 lg:flex-row">
                        <div class="flex flex-col w-full gap-3 m-5 md:flex-row">
                            <input aria-label="Check all"
                                class="transition-all duration-200 border-none checkbox checkbox-sm outline-dashed checked:outline-none"
                                type="checkbox">
                            <div class="flex w-full lg:w-4/5 md:w-4/5">
                                <img src="{{ asset('storage/' . $unit->image) }}"
                                    class="w-full rounded-xl lg:w-auto image-full image" alt="">
                                <div class="ml-4">
                                    <h1 class="text-sm font-semibold">{{ $unit->item->name }} {{ $unit->item->type }}
                                        {{ $unit->qty }}
                                        ({{ $unit->item->unit }})
                                    </h1>
                                    <p class="text-sm font-light">{{ $unit->item->merk }}, Rp {{ $unit->item->price }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-end w-full mt-4 mr-8 lg:w-1/5 md:w-1/5 lg:mt-0">
                                <div class="flex gap-2">
                                    <!-- REMOVE BUTTON -->
                                    <x-button class="btn-outline btn-sm join-item" icon="o-trash" />
                                    <div class="border join join-horizontal border-base-content/20">
                                        <!-- MINUS BUTTON -->
                                        <x-button icon="m-minus" class="join-item btn-sm btn-ghost" />
                                        <button
                                            class="px-3 font-semibold normal-case border-none btn border-base-content/20 md:flex btn-sm btn-ghost join-item">{{ $unit->qty }}</button>
                                        <!-- PLUS BUTTON -->
                                        <x-button icon="m-plus" class="join-item btn-sm btn-ghost" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>

    <!-- Perihal (Confirmation) section -->
    <div class="relative w-full mt-3 lg:mt-5 lg:ml-2 lg:w-1/3">
        <div aria-label="card" class="p-5 border rounded-lg shadow-lg bg-base-100 dark:border-none lg:sticky lg:top-5">
            <div class="flex flex-col gap-2">
                <h1 class="text-xl font-semibold">Konfirmasi Barang</h1>
                <div class="flex justify-between">
                    <p class="text-sm">Total items</p>
                    <p class="text-sm font-semibold">{{ $totalQty }}</p>
                </div>
                <hr class="my-3">
            </div>
            <form method="dialog">
                <div class="flex flex-col">
                    <label class="w-full py-2 form-control">
                        <x-textarea label="Perihal" wire:model="perihal" placeholder="Type here ..."
                            hint="Max 200 chars" rows="5"
                            class="transition-all duration-200 border-none outline-dashed" />
                    </label>
                </div>
                <x-button label="Kirim ({{ $items->count() }})"
                    class="items-center w-full text-white btn-outline bg-dark" />
            </form>
        </div>
    </div>
</div>
