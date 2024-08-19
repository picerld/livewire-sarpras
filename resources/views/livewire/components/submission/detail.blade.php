<div class="min-h-[85vh]">
    <x-button label="See all pengajuan" link="/submissions" icon="c-chevron-left"
        class="text-sm text-white bg-dark btn-outline btn-sm" spinner />

    <div class="flex flex-wrap w-full py-4">
        @foreach ($submissions as $submission)
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <x-card title="{{ $submission->item->name }}" class="m-2" shadow>
                    <p class="text-sm font-semibold">
                        {{ $submission->qty }} {{ $submission->item->unit }}
                    </p>
                    
                    <x-slot:menu>
                        <!-- adding badge for approved submission -->
                        @if ($submission->qty_accepted > 0)
                            <x-button icon="m-check-badge" class="btn-circle btn-ghost btn-sm" aria-label="accepted submission" />
                        @else
                            <x-button icon="o-share" class="btn-circle btn-sm" />
                            <x-icon name="o-heart" class="cursor-pointer" />
                        @endif
                    </x-slot:menu>
                    <x-slot:actions>
                        <!-- if submission is accepted, cannot be approved -->
                        @if ($submission->qty_accepted === 0)
                            <x-button label="Accept" wire:click="approval({{ $submission->id }})" icon="o-check-circle"
                                class="w-full mt-3 text-sm btn-outline btn-sm" spinner />
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
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        @if (!empty($submissionItem))
            <h1 class="py-4 text-lg font-bold">{{ $submissionItem->item->name }} ({{ $submissionItem->item->stock }}
                {{ $submissionItem->item->unit }})</h1>
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