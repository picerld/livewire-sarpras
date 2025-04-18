<x-card>
    <x-header wire:model.live.debounce="search" title="Permintaan" class="px-3 pt-3" size="text-3xl"
        subtitle="Permintaan Table" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter submission" responsive />
            <x-dropdown label="Export" class="text-white btn-outline bg-dark hover:opacity-90">
                <x-menu-item title="Export Csv" icon="o-arrow-up-on-square-stack" wire:click="exportCsv" />
                <x-menu-item title="Export Pdf" icon="o-arrow-up-on-square-stack" wire:click="requestPdfModal" />
            </x-dropdown>
            <x-button icon-right="m-plus" label="Add" wire:click="createRequestModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create submission" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$requests" :sort-by="$sortBy" link="/requests/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[5, 20, 50]">
        {{-- @scope('users_name', $submission)
            <x-button icon="o-trash" wire:click="delete({{ $submission->id }})"
                class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
        @endscope --}}
        @scope('cell_status', $request)
            <x-badge :value="$request->status"
                class=" btn-ghost btn-outline {{ $request->status == 'pending' ? '' : 'bg-dark text-white' }}" />
        @endscope

        @scope('cell_regarding', $request)
            @if (Str::length($request->regarding) > 20)
                <!-- handle for too long description -->
                {{ Str::limit($request->regarding, 20) }}
            @else
                {{ $request->regarding }}
            @endif
        @endscope

        @scope('cell_characteristic', $request)
            <x-badge :value="$request->characteristic ? $request->characteristic : 'none'" class="text-white btn-ghost btn-outline bg-dark" />
        @endscope

        @scope('actions', $request)
            <x-button icon="o-trash" wire:click="delete({{ $request->id }})"
                class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />

    <x-modal wire:model="requestExportPdf" class="backdrop-blur modal-bottom lg:modal-middle md:modal-middle"
        box-class="w-full lg:min-w-[400px] md:min-w-[400px] max-h-[80vh]">
        <div class="flex flex-col gap-3">
            <p class="text-sm">Press `ESC` or click outside to close.</p>

            <!-- DATEPICKER PLUGIN -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

            <form action="{{ route('requests.export') }}" method="POST" target="_blank">
                @csrf

                <div class="flex flex-col gap-4 my-3">
                    <x-datepicker class="cursor-pointer" label="Tanggal Mulai" name="fromDate" icon="o-calendar"
                        hint="optional" class="cursor-pointer border-dark focus:border-dark focus:outline-black" />
                    <x-datepicker class="cursor-pointer" label="Tanggal Selesai" name="toDate" icon="o-calendar"
                        hint="optional" class="cursor-pointer border-dark focus:border-dark focus:outline-black" />
                </div>

                <div class="flex flex-col gap-2 my-1">
                    <label class="w-full form-control">
                        <div class="label">
                            <span class="text-sm font-semibold">Unit Kerja</span>
                        </div>
                        <select name="nip" class="w-full border-black cursor-pointer select">
                            <option value="">SEMUA</option>
                            @foreach ($userNameExplode as $user)
                                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="label">
                            <span class="label-text-alt">optional</span>
                        </div>
                    </label>

                    <label class="w-full form-control">
                        <div class="label">
                            <span class="text-sm font-semibold">Status Permintaan</span>
                        </div>
                        <select name="status" class="w-full border-black cursor-pointer select">
                            <option value="">SEMUA</option>
                            @foreach ($status as $sts)
                                <option value="{{ $sts['id'] }}">{{ $sts['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="label">
                            <span class="label-text-alt">optional</span>
                        </div>
                    </label>
                </div>

                <x-button label="Unduh Laporan!" class="w-full text-white btn-outline bg-dark btn"
                    icon="o-arrow-down-on-square-stack" type="submit" />
            </form>
        </div>
    </x-modal>

    <x-modal wire:model="createRequest" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="pb-5 text-sm">Press `ESC` or click outside to close.</p>
        <livewire:components.request.form-request />
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="requests" no-separator>
            <!-- User Filter -->
            <x-choices-offline label="Unit Kerja" wire:model="selectedUser" :options="$users" searchable single />
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
