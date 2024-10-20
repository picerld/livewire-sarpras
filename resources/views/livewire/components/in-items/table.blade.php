<x-card>
    <x-header wire:model.live.debounce="search" title="Barang Masuk" class="px-3 pt-3" size="text-3xl" subtitle="Items Table"
        progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                placeholder="Search..." autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter item" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="createItemsModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create item" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$itemsIn" :sort-by="$sortBy" link="/in-items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[5, 20, 50]">

        @scope('actions', $itemsIn)
            <div class="flex gap-3">
                <x-button icon="o-folder-open" class="btn-sm btn-ghost dark:text-slate-300 btn-outline"
                    aria-label="delete item" wire:click="inItemImageModal({{ $itemsIn->id }})" spinner />
                <x-button icon="o-trash" wire:click="delete({{ $itemsIn->id }})"
                    class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
            </div>
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>


    <x-spotlight />

    <x-modal wire:model="inItemImage" class="backdrop-blur"
        box-class="w-full lg:min-w-[700px] md:min-w-[700px] max-h-[65vh]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>

        <!-- FIX UX WHILE UPDATING THE IMAGE -->

        <x-card class="w-full">
            @if ($itemInDetail)
                <x-form wire:submit.prevent="save" class="w-full" no-separator>
                    {{ $itemInDetail->id }}

                    @if ($itemInDetail->image)
                    <div class="flex flex-col gap-5">
                        <img src="{{ asset('storage/' . $itemInDetail->image) }}" class="w-full"
                            aria-labelledby="{{ $itemInDetail->id }}" alt="{{ $itemInDetail->name }}" />

                        <x-file wire:model="newIncomingItem.image"
                            accept="image/png, image/jpeg, image/jpg, image/webp">
                        </x-file>
                    </div>
                    @else
                        <x-file wire:model="newIncomingItem.image"
                            accept="image/png, image/jpeg, image/jpg, image/webp">
                        </x-file>
                    @endif

                    <x-slot:actions>
                        <x-button label="Save" icon="c-paper-airplane" class="text-white btn-primary" type="submit"
                            spinner="save" />
                    </x-slot:actions>
                </x-form>
            @else
                <p>No image available for this item.</p>
            @endif
        </x-card>
    </x-modal>


    <x-modal wire:model="createItems" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            <livewire:components.in-items.form-item-in />
        </x-card>
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="itemsIn" no-separator>
            <!-- User Filter -->
            <x-choices-offline label="User" wire:model="selectedUser" :options="$users" searchable inline single />
            <x-choices-offline label="Supplier" wire:model="selectedSupplier" :options="$suppliers" searchable inline
                single />

            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" />
            <x-input type="date" label="To Date" wire:model="toDate" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" icon="c-paper-airplane" type="submit"
                    spinner="itemsIn" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</x-card>
