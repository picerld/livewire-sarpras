<x-card>
    <x-header wire:model.live.debounce="search" title="Barang Keluar" class="px-3 pt-3" size="text-3xl"
        subtitle="Items Table" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                placeholder="Search..." autocomplete="off" />
            <x-dropdown label="Export" class="text-white btn-outline bg-dark hover:opacity-90">
                <x-menu-item title="Export Csv" icon="o-arrow-up-on-square-stack" wire:click="exportCsv" />
                <x-menu-item title="Export Pdf" icon="o-arrow-up-on-square-stack" wire:click="outItemCsvModal" />
            </x-dropdown>
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter item" responsive />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$itemsOut" :sort-by="$sortBy" link="/out-items/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[5, 20, 50]">
        @scope('cell_status', $itemsOut)
            <x-badge :value="$itemsOut->status"
                class=" btn-ghost btn-outline {{ $itemsOut->status == 'not taken' ? '' : 'bg-dark text-white' }}" />
        @endscope

        @scope('cell_updated_at', $itemsOut)
            {{ $itemsOut->updated_at ? $itemsOut->updated_at : 'not taken yet' }}
        @endscope

        @scope('actions', $itemsOut)
            <x-button icon="o-trash" wire:click="delete({{ $itemsOut->id }})"
                class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />

    <x-modal wire:model="outItemExportPdf" class="backdrop-blur"
        box-class="w-full lg:min-w-[400px] md:min-w-[400px] max-h-[65vh]">
        <div class="flex flex-col gap-3">
            <p class="text-sm">Press `ESC` or click outside to close.</p>

            <!-- DATEPICKER PLUGIN -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

            <form action="{{ route('out-items.export') }}" method="POST" target="_blank">
                @csrf

                <div class="flex flex-col gap-4 my-5">
                    <x-datepicker class="cursor-pointer" label="Tanggal Mulai" name="fromDate" icon="o-calendar"
                        hint="optional" class="cursor-pointer border-dark focus:border-dark focus:outline-black" />
                    <x-datepicker class="cursor-pointer" label="Tanggal Selesai" name="toDate" icon="o-calendar"
                        hint="optional" class="cursor-pointer border-dark focus:border-dark focus:outline-black" />
                </div>

                <x-button label="Unduh Laporan!" class="w-full text-white btn-outline bg-dark btn"
                    icon="o-arrow-down-on-square-stack" type="submit" />
            </form>
        </div>
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="itemsOut" no-separator>
            <!-- User Filter -->
            <x-choices-offline label="User" wire:model="selectedUser" :options="$users" searchable inline single />
            <x-choices-offline label="Status" wire:model="selectedStatus" :options="$status" searchable inline single />

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
