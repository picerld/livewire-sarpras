<x-card>
    <x-header wire:model.live.debounce="search" title="Pengadaan" class="px-3 pt-3" size="text-3xl"
        subtitle="Pengadaan Table" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter submission" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="createSubmissionModal"
                class="text-white bg-dark dark:bg-slate-100 hover:bg-dark hover:opacity-90 dark:text-black" responsive
                aria-label="create submission" />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$submissions" :sort-by="$sortBy" link="/submissions/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        {{-- @scope('users_name', $submission)
            <x-button icon="o-trash" wire:click="delete({{ $submission->id }})"
                class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
        @endscope --}}
        @scope('cell_status', $submission)
            <!-- ADD CONDITION IF 'accepted' and 'rejected' -->
            <x-badge :value="$submission->status" class="btn-ghost btn-outline" />
        @endscope

        @scope('actions', $submission)
            <x-button icon="o-trash" wire:click="delete({{ $submission->id }})"
                class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
        @endscope
    </x-table>

    <x-spotlight />

    <x-modal wire:model="createSubmission" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="pb-5 text-sm">Press `ESC` or click outside to close.</p>
        <livewire:components.submission.form-submission />
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="submissions" no-separator>
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
