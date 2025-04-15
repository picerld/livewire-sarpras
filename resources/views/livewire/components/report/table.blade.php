<div class="min-h-[86vh]">
    <x-button label="See all reports" link="/reports" icon="c-chevron-left"
        class="mt-2 mb-5 text-sm text-white bg-dark btn-outline btn-sm" spinner />
    @if ($formattedItems->count() > 0)
        <x-card>
            <x-header wire:model.live.debounce="search"
                title="{{ $formattedItems[0]->name ? $formattedItems[0]->name : 'Items' }}" class="px-3 pt-3"
                size="text-3xl" subtitle="Items " progress-indicator separator>
                <x-slot:actions>
                    <x-dropdown label="Export" class="text-white btn-outline bg-dark hover:opacity-90">
                        <x-menu-item title="Export Pdf" icon="o-arrow-up-on-square-stack" wire:click="reportPdfModal" />
                    </x-dropdown>
                </x-slot:actions>
            </x-header>

            <x-table :headers="$headers" :rows="$formattedItems" class="bg-white rounded dark:bg-dark">
                @scope('cell_no', $formattedItems)
                    {{ $loop->index + 1 }}
                @endscope
                
                @scope('cell_outgoing_date', $formattedItems)
                    <p>{{ $formattedItems->outgoing_date ?? 'N/A' }}</p>
                @endscope

                @scope('cell_incoming_date', $formattedItems)
                    <p>{{ $formattedItems->incoming_date ?? 'N/A' }}</p>
                @endscope

                @scope('cell_incoming_qty', $formattedItems)
                    @if ($formattedItems->incoming_qty && $formattedItems->unit)
                        <p>{{ $formattedItems->incoming_qty }} {{ $formattedItems->unit }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                @endscope

                @scope('cell_outgoing_qty', $formattedItems)
                    @if ($formattedItems->outgoing_qty && $formattedItems->unit)
                        <p>{{ $formattedItems->outgoing_qty }} {{ $formattedItems->unit }}</p>
                    @else
                        <p>N/A</p>
                    @endif
                @endscope

                <x-slot:empty>
                    <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                        class="border-none bg-base-100">
                    </x-alert>
                </x-slot:empty>

            </x-table>
        </x-card>

        <x-modal wire:model="reportExportPdf" class="backdrop-blur"
            box-class="w-full lg:min-w-[400px] md:min-w-[400px] max-h-[65vh]">
            <div class="flex flex-col gap-3">
                <p class="text-sm">Press `ESC` or click outside to close.</p>

                <!-- DATEPICKER PLUGIN -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

                <form action="{{ route('report.export', ['id' => $formattedItems[0]->id]) }}" method="POST"
                    target="_blank">
                    @csrf

                    <div class="flex flex-col gap-4 my-5">
                        <x-datepicker class="cursor-pointer" label="Tanggal Masuk" name="incomingDate" icon="o-calendar"
                            hint="optional" class="cursor-pointer border-dark focus:border-dark focus:outline-black" />
                        <x-datepicker class="cursor-pointer" label="Tanggal Keluar" name="outgoingDate" icon="o-calendar"
                            hint="optional" class="cursor-pointer border-dark focus:border-dark focus:outline-black" />
                    </div>

                    <x-button label="Unduh Laporan!" class="w-full text-white btn-outline bg-dark btn"
                        icon="o-arrow-down-on-square-stack" type="submit" />
                </form>
            </div>
        </x-modal>
    @else
        <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
            class="border-none bg-base-100">
        </x-alert>
    @endif

</div>
