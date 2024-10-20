<x-form id="submissionForm" wire:submit.prevent="store" class="space-y-2" autocomplete="off" no-separator>
    <div class="grid w-full grid-cols-1 gap-4">
        <x-choices-offline label="Unit" :options="$users" id="unit_id" wire:model="nip" hint="Please select an item"
            class="w-full" icon="o-radio" inline single searchable />
        <x-textarea label="Perihal" wire:model="regarding" placeholder="Type here ..." rows="3" inline />

        <x-tabs wire:model="selectedItemTab">
            <!-- tab for existing items -->
            <x-tab name="existing-item-tab" label="Barang" icon="o-inbox-stack">
                <div class="grid w-full gap-4">
                    @foreach ($inputs as $key => $value)
                        <div
                            class="grid w-full gap-4 p-5 border border-gray-400 border-dashed rounded-md md:grid-cols-6 md:items-center">
                            <div class="col-span-6">
                                <x-choices-offline label="Items" :options="$items"
                                    wire:model="inputs.{{ $key }}.item_code" hint="Please select an item"
                                    class="w-full" icon="o-radio" inline single searchable>

                                    @scope('item', $item)
                                        <x-list-item :item="$item" sub-value="type">
                                            <x-slot:avatar>
                                                <x-icon name="o-user" class="w-8 h-8 p-2 bg-orange-100 rounded-full" />
                                            </x-slot:avatar>
                                            <x-slot:actions>
                                                <x-badge :value="$item->category->aliases" />
                                            </x-slot:actions>
                                        </x-list-item>
                                    @endscope

                                    @scope('selection', $item)
                                        {{ $item->name }} ({{ $item->type }})
                                    @endscope
                                </x-choices-offline>
                            </div>
                            <div class="col-span-4">
                                <x-input type="number" wire:model="inputs.{{ $key }}.qty" class="w-full"
                                    icon="o-funnel" min="1" />
                            </div>
                            <div class="col-span-2">
                                @if ($key >= 1)
                                    <x-button type="button" label="Remove"
                                        wire:click.prevent="removeInput('exist-item', {{ $key }})"
                                        class="flex w-full btn-ghost btn-outline" icon="o-document-minus" />
                                @else
                                    <x-button type="button" label="Remove" class="flex w-full btn-ghost btn-outline"
                                        icon="o-document-minus" />
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-tab>

            <!-- tab for new/custom items -->
            <x-tab name="new-item-tab" label="Barang baru" icon="o-inbox">
                <div class="grid w-full gap-4">
                    @foreach ($inputNewItems as $key => $value)
                        <div class="grid w-full gap-3 p-5 border border-gray-400 border-dashed rounded-md">
                            <div class="col-span-12">
                                <x-input wire:model="inputNewItems.{{ $key }}.custom_item" class="w-full"
                                    icon="o-funnel" placeholder="Enter new item name" />
                            </div>
                            <div class="col-span-10">
                                <x-input type="number" wire:model="inputNewItems.{{ $key }}.custom_item_qty"
                                    class="w-full" icon="o-funnel" min="1" />
                            </div>
                            <div class="col-span-2">
                                @if ($key >= 1)
                                    <x-button type="button" label="Remove"
                                        wire:click.prevent="removeInput('new-item', {{ $key }})"
                                        class="flex w-full btn-ghost btn-outline" icon="o-document-minus" />
                                @else
                                    <x-button type="button" label="Remove" class="flex w-full btn-ghost btn-outline"
                                        icon="o-document-minus" />
                                @endif
                            </div>

                            <div class="col-span-12">
                                <x-textarea label="Deskripsi" placeholder="Deskripsi barang ..." rows="3"
                                    class="w-full" inline />
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-tab>
        </x-tabs>

        <x-button type="button" label="Add" icon="o-sparkles"
            wire:click.prevent="addInput('{{ $selectedItemTab == 'existing-item-tab' ? 'exist-item' : 'new-item' }}')"
            class="mt-5 btn btn-ghost btn-outline" />
    </div>

    <x-slot:actions>
        <x-button label="Submit" icon="c-paper-airplane" class="w-full text-white btn-primary md:w-auto lg:w-auto"
            type="submit" spinner="store" />
    </x-slot:actions>
</x-form>
