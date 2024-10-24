<x-card class="min-h-[60vh] mx-20">
    <x-header wire:model.live.debounce="search" title="My Items" class="px-3 pt-3" size="text-3xl"
        subtitle="My items transaction" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter submission" responsive />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$itemsOut" :sort-by="$sortBy" link="/out-items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[5, 20, 50]">

        @scope('cell_status', $itemsOut)
            <x-badge :value="$itemsOut->status"
                class=" btn-ghost btn-outline {{ $itemsOut->status == 'not taken' ? '' : 'bg-dark text-white' }}" />
        @endscope

        @scope('actions', $itemsOut)
            <x-button icon="o-information-circle" wire:click="detailOutgoingItemModal({{ $itemsOut->id }})"
                class="text-white btn-sm btn-ghost bg-dark btn-outline" aria-label="delete item" spinner />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />

    <x-modal wire:model="detailOutgoingItem" class="backdrop-blur"
        box-class="w-full lg:min-w-[800px] md:min-w-[800px] max-h-[70vh]">
        <p class="pb-5 text-sm text-black">Press `ESC` or click outside to close.</p>
        @if (isset($item))
            {{-- <div class="p-4 bg-gray-900 border-l-4 border-collapse border-gray-600 rounded-lg">
                <article class="prose text-white">
                    <h1 class="text-base font-semibold">Perihal</h1>
                    <x-button label="Update Status!" class="w-full text-white btn-outline bg-dark" />
                </article>
            </div> --}}

            <div class="p-4 rounded-lg">
                <x-button label="Update Status!" wire:click.prevent="updateStatus({{ $item[0]->outgoing_item_code }})"
                    class="w-full text-white btn-outline bg-dark" spinner />
            </div>


            <div class="grid w-full grid-cols-1 py-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($item as $outgoingItem)
                    <div class="m-2">
                        <x-card
                            title="{{ $outgoingItem->item->name ?? $outgoingItem->custom_item }} ({{ $outgoingItem->item->type ?? 'null' }})"
                            class="border shadow">
                            <x-icon name="o-tag"
                                label="{{ $outgoingItem->item->merk ?? $outgoingItem->custom_item }}" />
                            <p class="text-sm font-semibold">
                                {{ $outgoingItem->qty }}
                                {{ $outgoingItem->item->unit ?? '' }}
                            </p>
                            <x-slot:figure>
                                <img src="{{ !empty($outgoingItem->item->images) ? asset('/storage/' . $outgoingItem->item->images) : asset('img/outgoingItem.webp') }}"
                                    class="object-cover w-full h-40"
                                    aria-labelledby="{{ $outgoingItem->item->id ?? $outgoingItem->custom_item }}"
                                    alt="{{ $outgoingItem->item->name ?? $outgoingItem->custom_item }}" />
                            </x-slot:figure>
                            <x-slot:menu>
                                <x-button icon="m-shield-check" class="btn-circle btn-ghost btn-sm"
                                    aria-label="accepted outgoingItem" />
                            </x-slot:menu>
                        </x-card>
                    </div>
                @endforeach
            </div>
        @endif
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="requests" no-separator>
            <!-- User Filter -->
            <x-choices-offline label="Status" wire:model="selectedStatus" :options="$status" searchable single />

            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" />
            <x-input type="date" label="To Date" wire:model="toDate" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" type="submit" icon="c-paper-airplane"
                    spinner="submissions" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</x-card>
