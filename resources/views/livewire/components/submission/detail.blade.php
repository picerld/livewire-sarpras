<div class="min-h-[85vh]">
    <div class="flex justify-between">
        <x-button label="See all pengadaan" link="/submissions" icon="c-chevron-left"
            class="text-sm text-white bg-dark btn-outline btn-sm" spinner />

        @can('acceptTransaction')
            <!-- HANDLE BUTTON ON MOBILE DEVICE -->
            <x-dropdown label="Option" class="flex btn btn-outline btn-sm lg:hidden md:hidden" no-x-anchor right>
                <livewire:components.submission.form-acceptance :submissionCode="$submissions[0]->submission_code" />
            </x-dropdown>

            <div class="hidden md:flex lg:flex">
                <livewire:components.submission.form-acceptance :submissionCode="$submissions[0]->submission_code" />
            </div>
            <!-- END HANDLE -->
        @endcan
    </div>

    <div class="grid w-full grid-cols-1 py-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($submissions as $submission)
            <div class="m-2">
                <x-card
                    title="{{ $submission->item->name ?? $submission->custom_item }} ({{ $submission->item->type ?? 'null' }})"
                    class="shadow">
                    <x-icon name="o-tag" label="{{ $submission->item->merk ?? $submission->custom_item }}" />
                    <p class="text-sm font-semibold">
                        {{ $submission->qty_accepted > 0 && $submission->qty_accepted !== $submission->qty ? $submission->qty_accepted : $submission->qty }}
                        {{ $submission->item->unit ?? "" }}
                    </p>
                    <x-slot:figure>
                        <img src="{{ !empty($submission->item->images) ? asset('/storage/' . $submission->item->images) : asset('img/submission.webp') }}"
                            height="200" width="230" class="object-cover w-full min-h-40 max-h-40"
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
                        <!-- Check if qty_accepted is greater than 0 for submission status -->
                        @if ($submission->qty_accepted === 0)
                            <!-- HANDLE GATE -->
                            @can('acceptTransaction')
                                <x-button label="Accept" wire:click="approval({{ $submission->id }})" icon="o-check-circle"
                                    class="w-full mt-3 text-sm btn-outline btn-sm" spinner />
                            @else
                                <x-button icon="o-bell-alert" class="w-full mt-3 text-sm btn-outline btn-sm" />
                            @endcan
                            <!-- END -->
                        @else
                            <x-button label="Done!" icon="o-check-badge"
                                class="w-full mt-3 text-sm text-white btn-outline bg-dark btn-sm" spinner />
                        @endif
                    </x-slot:actions>
                </x-card>
            </div>
        @endforeach
    </div>

    <x-spotlight />

    <x-modal wire:model="approvalModal" class="backdrop-blur" box-class="w-full p-5">
        <!-- FIX THIS MODAL UI -->

        <p class="text-sm">Press `ESC` or click outside to close.</p>
        @if (!empty($submissionItem))
            <div class="py-4">
                <h1 class="text-lg font-bold">{{ $submissionItem->item->name }} ({{ $submissionItem->item->stock }}
                    {{ $submissionItem->item->unit }}), ({{ $submissionItem->item->minimum_stock }}
                    {{ $submissionItem->item->unit }})</h1>
                <h3 class="text-base font-semibold">{{ $submissionItem->qty }} {{ $submissionItem->item->unit }}</h3>
            </div>
            <x-form wire:submit="save" no-separator>
                <x-input label="Quantity" wire:model="submissionApproved.qty" type="number" min="1"
                    icon="o-document-chart-bar" inline />

                <x-slot:actions>
                    <x-button label="Accept!" class="text-white btn-primary hover:opacity-80" type="submit"
                        spinner="save" wire:click="save({{ $submissionItem->id }})" />
                </x-slot:actions>
            </x-form>
        @endif
    </x-modal>
</div>
