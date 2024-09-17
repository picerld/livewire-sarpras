<div class="min-h-[85vh]">
    <div class="flex justify-between">
        <x-button label="See all permintaan" link="/requests" icon="c-chevron-left"
            class="text-sm text-white bg-dark btn-outline btn-sm" spinner />

        @can('acceptTransaction')
            <!-- HANDLE BUTTON ON MOBILE DEVICE -->
            <x-dropdown label="Option" class="flex btn btn-outline btn-sm lg:hidden md:hidden" no-x-anchor right>
                <livewire:components.request.form-acceptance :requestCode="$requests[0]->request_code" />
            </x-dropdown>

            <div class="hidden md:flex lg:flex">
                <livewire:components.request.form-acceptance :requestCode="$requests[0]->request_code" />
            </div>
            <!-- END HANDLE -->
        @endcan
    </div>

    <div class="grid w-full grid-cols-1 py-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($requests as $request)
            <div class="m-2">
                <x-card title="{{ $request->item->name }} ({{ $request->item->type }})" class="shadow">
                    <x-icon name="o-tag" label="{{ $request->item->merk }}" />
                    <p class="text-sm font-semibold">
                        {{ $request->qty_accepted > 0 && $request->qty_accepted !== $request->qty ? $request->qty_accepted : $request->qty }}
                        {{ $request->item->unit }}
                    </p>
                    <x-slot:figure>
                        <img src="{{ asset('/storage/' . $request->item->images) }}" height="200" width="230"
                            class="object-cover w-full min-h-40 max-h-40" aria-labelledby="{{ $request->item->id }}"
                            alt="{{ $request->item->name }}" />
                    </x-slot:figure>
                    <x-slot:menu>
                        <!-- adding badge for approved request -->
                        @if ($request->qty_accepted > 0 && $request->qty_accepted !== $request->qty)
                            <x-button icon="m-shield-exclamation" class="btn-circle btn-ghost btn-sm" />
                        @elseif(!$request->qty_accepted)
                            <x-button icon="o-signal" class="btn-circle btn-sm" />
                        @else
                            <x-button icon="m-shield-check" class="btn-circle btn-ghost btn-sm"
                                aria-label="accepted request" />
                        @endif
                    </x-slot:menu>
                    <x-slot:actions>
                        <!-- Check if qty_accepted is greater than 0 for request status -->
                        @if ($request->qty_accepted === 0)
                            <!-- HANDLE GATE -->
                            @can('acceptTransaction')
                                <x-button label="Accept" wire:click="approval({{ $request->id }})" icon="o-check-circle"
                                    class="w-full mt-3 text-sm btn-outline btn-sm" spinner />
                            @else
                                <x-button icon="o-bell-alert"
                                    class="w-full mt-3 text-sm text-white btn-outline bg-dark btn-sm" />
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
        @if (!empty($requestItem))
            <div class="py-4">
                <h1 class="text-lg font-bold">{{ $requestItem->item->name }} ({{ $requestItem->item->stock }}
                    {{ $requestItem->item->unit }}), ({{ $requestItem->item->minimum_stock }}
                    {{ $requestItem->item->unit }})</h1>
                <h3 class="text-base font-semibold">{{ $requestItem->qty }} {{ $requestItem->item->unit }}</h3>
            </div>
            <x-form wire:submit="save" no-separator>
                <x-input label="Quantity" wire:model="requestApproved.qty" type="number" min="1"
                    icon="o-document-chart-bar" inline />

                <x-slot:actions>
                    <x-button label="Accept!" class="text-white btn-primary hover:opacity-80" type="submit"
                        spinner="save" wire:click.prevent="save({{ $requestItem->id }})" />
                </x-slot:actions>
            </x-form>
        @endif
    </x-modal>
</div>
