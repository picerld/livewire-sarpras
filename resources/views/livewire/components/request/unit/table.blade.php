<x-card class="min-h-[60vh] mx-20">
    <x-header wire:model.live.debounce="search" title="My Requests" class="px-3 pt-3" size="text-3xl"
        subtitle="My request transaction" progress-indicator separator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                autocomplete="off" />
            <x-button icon="o-funnel" class="text-black dark:text-white/80" wire:click="tableDrawer"
                aria-label="filter submission" responsive />
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
            <x-button icon="o-information-circle" wire:click="detailRequestModal({{ $request->id }})"
                class="text-white btn-sm btn-ghost bg-dark btn-outline" aria-label="show item" spinner />
        @endscope

        <x-slot:empty>
            <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
            </x-alert>
        </x-slot:empty>
    </x-table>

    <x-spotlight />

    <x-modal wire:model="createRequest" class="backdrop-blur" box-class="w-full lg:min-w-[800px] md:min-w-[800px]">
        <p class="pb-5 text-sm text-black">Press `ESC` or click outside to close.</p>

        <livewire:components.request.unit.formRequest />
    </x-modal>

    <x-modal wire:model="detailRequest" class="backdrop-blur"
        box-class="w-full lg:min-w-[700px] md:min-w-[700px] max-h-[70vh]">
        <p class="pb-5 text-sm">Press `ESC` or click outside to close.</p>
        @if (isset($item))
            <div class="p-4 bg-gray-900 border-l-4 border-collapse border-gray-600 rounded-lg">
                <article class="prose text-white">
                    <h1 class="text-base font-semibold">Perihal</h1>
                    <p class="text-sm italic">{{ $item[0]->request_regarding }}</p>
                </article>
            </div>

            <div class="grid w-full grid-cols-1 py-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($item as $submission)
                    <div class="m-2">
                        <x-card
                            title="{{ $submission->item->name ?? $submission->custom_item }} ({{ $submission->item->type ?? 'null' }})"
                            class="shadow">
                            <x-icon name="o-tag" label="{{ $submission->item->merk ?? $submission->custom_item }}" />
                            <p class="text-sm font-semibold">
                                {{ $submission->qty_accepted > 0 && $submission->qty_accepted !== $submission->qty ? $submission->qty_accepted : $submission->qty }}
                                {{ $submission->item->unit ?? '' }}
                            </p>
                            <x-slot:figure>
                                <img src="{{ !empty($submission->item->images) ? asset('/storage/' . $submission->item->images) : asset('img/submission.webp') }}"
                                    class="object-cover w-full h-40"
                                    aria-labelledby="{{ $submission->item->id ?? $submission->custom_item }}"
                                    alt="{{ $submission->item->name ?? $submission->custom_item }}" />
                            </x-slot:figure>
                            <x-slot:menu>
                                <!-- adding badge for approved submission -->
                                @if ($submission->qty_accepted > 0 && $submission->qty_accepted !== $submission->qty)
                                    <x-button icon="m-shield-exclamation" class="btn-circle btn-ghost btn-sm" />
                                @elseif(!$submission->qty_accepted)
                                    <x-button icon="o-signal" class="btn-circle btn-sm" />
                                @else
                                    <x-button icon="m-shield-check" class="btn-circle btn-ghost btn-sm"
                                        aria-label="accepted submission" />
                                @endif
                            </x-slot:menu>
                            <x-slot:actions>
                            </x-slot:actions>
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
