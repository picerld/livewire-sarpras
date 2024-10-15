<div class="flex flex-col gap-3 px-10 lg:flex-row">
    <div class="flex flex-col w-full gap-5 mt-5 lg:w-2/3">
        <div class="flex justify-between p-5 border rounded-lg bg-base-100 dark:border-none">
            <div class="flex gap-3">
                <input id="pilih-semua" aria-label="Check all"
                    class="transition-all duration-200 border-none checkbox checkbox-sm outline-dashed checked:outline-none"
                    type="checkbox">
                <label for="pilih-semua" class="text-sm font-bold">Pilih Semua ({{ $items->count() }})</label>
            </div>
            <button class="text-sm font-bold text-black">Hapus</button>
        </div>

        @forelse ($items as $unit)
            <div aria-label="Card" class="border border-t-0 dark:border-none card bg-base-100">
                <div class="p-0 card-body">
                    <div class="flex flex-col w-full gap-4 lg:flex-row">
                        <div class="flex flex-col w-full gap-3 m-5 md:flex-row">
                            <input id="pilih-semua" aria-label="Check all"
                                class="transition-all duration-200 border-none checkbox checkbox-sm outline-dashed checked:outline-none"
                                type="checkbox">
                            <div class="flex w-full lg:w-4/5 md:w-4/5">
                                <img src="{{ asset('storage/' . $unit->image) }}"
                                    class="w-full rounded-xl lg:w-auto image-full image" alt="">
                                <div class="mt-4 ml-4">
                                    <h1 class="text-sm font-semibold">{{ $unit->item->name }} {{ $unit->qty }} ({{ $unit->item->unit }})</h1>
                                    <p class="mt-2 text-sm text-pretty">{{ $unit->item->description }}</p>
                                </div>
                            </div>
                            <div class="flex items-end w-full mt-4 mr-8 lg:w-1/5 md:w-1/5 lg:mt-0">
                                <div class="flex gap-2">
                                    <button
                                        class="normal-case btn-sm btn border-base-content/20 md:flex btn-ghost join-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img"
                                            class="text-dark dark:text-slate-200" font-size="20" width="1em"
                                            height="1em" viewBox="0 0 448 512">
                                            <path fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div class="border join join-horizontal border-base-content/20">
                                        <button
                                            class="normal-case border-none btn-sm btn border-base-content/20 md:flex btn-ghost join-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img"
                                                class="text-dark dark:text-slate-200" font-size="14" width="1em"
                                                height="1em" viewBox="0 0 448 512">
                                                <path fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button
                                            class="px-3 font-semibold normal-case border-none btn border-base-content/20 md:flex btn-sm btn-ghost join-item">1</button>
                                        <button
                                            class="normal-case border-none btn border-base-content/20 md:flex btn-sm btn-ghost join-item text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img"
                                                class="text-dark dark:text-slate-200" font-size="14" width="1em"
                                                height="1em" viewBox="0 0 448 512">
                                                <path fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z">
                                                </path>
                                            </svg>
                                        </button>
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

    <div class="w-full mt-3 lg:w-1/3 lg:mt-5 lg:ml-2">
        <div aria-label="card" class="p-5 border rounded-lg bg-base-100 dark:border-none">
            <h1 class="text-xl font-semibold">Konfirmasi Barang</h1>
            <form method="dialog">
                <div class="flex flex-col">
                    <label class="w-full py-2 form-control">
                        <div class="label">
                            <span class="font-medium label-text">Perihal</span>
                        </div>
                        <textarea class="w-full h-32 textarea outline-dashed focus:textarea-primary" placeholder="Type here ..."></textarea>
                    </label>
                </div>
                <x-button label="Kirim ({{ $items->count() }})" class="w-full text-white btn-outline bg-dark" />
            </form>
        </div>
    </div>
</div>
