<x-card>
    <x-header wire:model.live.debounce="search" title="{{ $isReport ? 'Reports' : 'Items' }}" class="px-3 pt-3"
        size="text-3xl" subtitle="Items Table" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black focus:border-dark placeholder:font-semibold"
                placeholder="Search..." autocomplete="off" />

            <!-- FILTER OPTIONAL -->
            {{-- <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter item" responsive /> --}}

            <x-button label="Import" icon-right="o-arrow-down-on-square-stack"
                class="text-white btn-outline bg-dark hover:opacity-90" wire:click="openImportModal"
                aria-label="filter item" responsive />
            <x-dropdown label="Export" class="text-white btn-outline bg-dark hover:opacity-90">
                <x-menu-item title="Export Csv" icon="o-arrow-up-on-square-stack" wire:click="exportCsv" />
                <x-menu-item title="Export Pdf" icon="o-arrow-up-on-square-stack" link="{{ route('items.export') }}"
                    no-wire-navigate />
            </x-dropdown>

            <x-button icon-right="m-plus" label="Add" wire:click="createItemsModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create item" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$items" :sort-by="$sortBy"
        link="{{ $isReport ? '/reports/{id}' : '/items/{id}' }}" class="bg-white rounded dark:bg-dark" with-pagination
        per-page="perPage" :per-page-values="[6, 20, 50]">
        @scope('cell_stock', $item)
            <p>{{ $item->stock > $item->minimum_stock ? $item->stock : $item->stock . ' !!' }}</p>
        @endscope

        @scope('cell_category_aliases', $item)
            <x-badge :value="$item->category->aliases ?? 'null'" class="text-white btn-ghost btn-outline bg-dark" />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />

    <x-modal wire:model="createItems" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            <x-form id="itemsForm" wire:submit.prevent="store" class="space-y-4" autocomplete="off" no-separator>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-input wire:model="newItem.name" id="name" label="Name" inline />
                    <x-input wire:model="newItem.merk" id="merk" label="Merk" inline />
                    <x-choices wire:model="newItem.category_id" label="Category" :options="$categories" single />
                    <x-choices wire:model="newItem.unit" label="Satuan" :options="$units" single />
                    <x-input wire:model="newItem.size" id="size" label="Size" inline />
                    <x-input label="Price" wire:model="newItem.price" suffix="Rp" money locale="id-ID" inline />
                    <x-input wire:model="newItem.type" id="type" label="Type" inline />
                    <x-input wire:model="newItem.color" id="color" label="Color" inline />
                    <x-input wire:model="newItem.stock" id="stock" type="number" label="Stok" min="1"
                        inline />
                    <x-input wire:model="newItem.minimum_stock" id="minimum_stock" label="Stok minimum" type="number"
                        min="1" inline />
                    <x-choices-offline wire:model="newItem.supplier_id" label="Supplier" :options="$suppliers" searchable
                        single />
                    <x-file wire:model="newItem.images" class="lg:mt-7"
                        accept="image/png, image/jpg, image/jpeg, image/webp" />
                </div>
                <x-textarea label="Deskripsi" wire:model="newItem.description" placeholder="Type here ..."
                    rows="3" hint="Description of your item" inline />
                {{-- <x-editor wire:model="newItem.description" label="Deskripsi" hint="The full product description"
                folder="public/" /> --}}

                <x-slot:actions>
                    <x-button label="Submit!" icon="c-paper-airplane" class="text-white btn-primary" type="submit"
                        spinner="store" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </x-modal>

    <x-modal wire:model="importModal" class="backdrop-blur" box-class="w-full lg:min-w-[400px] md:min-w-[400px]">
        <p class="text-sm">Press `ESC` or click outside to close.</p>

        <div class="flex flex-col mt-3">
            <p class="text-base">Unduh template excel</p>

            <div class="flex flex-col gap-2 mt-2">
                <x-button label="Download" class="btn-outline btn" icon="o-arrow-down-on-square-stack"
                    wire:click="downloadTemplate" />

                <!-- IMPORT SECTION -->
                <x-form wire:submit.prevent="import" no-separator>
                    <div class="file-input-wrapper">
                        <x-file wire:model="csv" change-text="Upload"
                            class="flex flex-col items-center justify-center w-full h-32 bg-gray-100 rounded-lg"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <div class="file-input-label">
                                <span class="text-xs">
                                    @if ($csv)
                                        {{ $csv->getClientOriginalName() }}
                                    @else
                                        Click to upload | Max 1MB
                                    @endif
                                </span>
                            </div>
                        </x-file>
                        <span class="text-sm font-semibold">
                            @if ($csv)
                                {{ $csv->getClientOriginalName() }}
                            @else
                                No file selected
                            @endif
                        </span>
                    </div>

                    <x-button type="submit" spinner="import" label="Upload" class="btn-outline btn"
                        icon="o-arrow-up-on-square-stack" />
                </x-form>
            </div>
        </div>
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="items" no-separator>
            <!-- Category Filter -->
            <x-choices label="Category" wire:model="selectedCategory" :options="$categories" searchable single />

            <!-- Date Range Filter -->
            <x-input type="number" label="Stock from" wire:model="fromStock" />
            <x-input type="number" label="Stock to" wire:model="toStock" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" type="submit" icon="c-paper-airplane"
                    spinner="items" />
            </x-slot:actions>
        </x-form>

    </x-drawer>
</x-card>
