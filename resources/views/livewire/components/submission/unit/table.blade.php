<div class="flex flex-wrap gap-5 mx-16 lg:flex-nowrap md:flex-nowrap">
    <div class="w-full md:w-1/4 lg:1/4">
        <x-card title="Hello!" class="min-h-[78vh]">
            Explore our items

            <x-slot:figure>
                <img src="{{ asset('img/submission.webp') }}" alt="submission" />
            </x-slot:figure>
            <x-slot:menu>
                <x-button icon="o-share" class="btn-circle btn-sm" />
                <x-icon name="o-heart" class="cursor-pointer" />
            </x-slot:menu>
            <x-slot:actions>
                <x-button link="{{ route('unit') }}" label="Let's go 👀"
                    class="text-white btn-outline btn-sm bg-dark" />
            </x-slot:actions>
        </x-card>
    </div>

    <div class="w-full md:w-3/4 lg:w-3/4">
        <x-card>
            <x-header wire:model.live.debounce="search" title="My Submissions" class="px-3 pt-3" size="text-4xl"
                subtitle="My submission trasaction" progress-indicator separator>
                <x-slot:actions>
                    <x-input wire:model="search" id="search" icon="o-magnifying-glass"
                        class="border-dark focus:outline-black placeholder:font-semibold" placeholder="Search..."
                        autocomplete="off" />
                </x-slot:actions>
            </x-header>

            <!-- USING TABLE -->
            <x-table :headers="$headers" :rows="$submissions" :sort-by="$sortBy" link="/submissions/{id}"
                class="bg-white rounded dark:bg-dark" with-pagination per-page="perPage" :per-page-values="[5, 20, 50]">
                {{-- @scope('users_name', $submission)
                    <x-button icon="o-trash" wire:click="delete({{ $submission->id }})"
                        class="btn-sm btn-ghost dark:text-slate-300 btn-outline" aria-label="delete item" spinner />
                @endscope --}}
                @scope('cell_status', $submission)
                    <x-badge :value="$submission->status"
                        class=" btn-ghost btn-outline {{ $submission->status == 'pending' ? '' : 'bg-dark text-white' }}" />
                @endscope

                @scope('cell_created_at', $submission)
                    {{ $submission->created_at->format('d M Y') }}
                @endscope

                @scope('actions', $submission)
                    <x-button icon="o-information-circle" wire:click="detailSubmissionModal({{ $submission->id }})"
                        class="text-white btn-sm btn-ghost bg-dark btn-outline" aria-label="delete item" spinner />
                @endscope

                <x-slot:empty>
                    <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
                        class="border-none bg-base-100">
                    </x-alert>
                </x-slot:empty>
            </x-table>

            <x-spotlight />

            <x-modal wire:model="detailSubmission" class="backdrop-blur modal-bottom lg:modal-middle md:modal-middle"
                box-class="w-full lg:min-w-[800px] md:min-w-[800px] max-h-[70vh]">
                <p class="pb-5 text-sm text-black">Press `ESC` or click outside to close.</p>
                @if (isset($item))
                    <div class="p-4 bg-gray-900 border-l-4 border-collapse border-gray-600 rounded-lg">
                        <article class="prose text-white">
                            <h1 class="text-base font-semibold">Perihal</h1>
                            <p class="text-sm italic">{{ $item[0]->submission_regarding }}</p>
                        </article>
                    </div>

                    <div class="grid w-full grid-cols-1 py-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($item as $submission)
                            <div class="m-2">
                                <x-card
                                    title="{{ $submission->item->name ?? $submission->custom_item }} ({{ $submission->item->type ?? 'null' }})"
                                    class="flex flex-col justify-between h-full my-2 border-2">
                                    <x-icon name="o-tag"
                                        label="{{ $submission->item->merk ?? $submission->custom_item }}" />
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
        </x-card>
    </div>
</div>
