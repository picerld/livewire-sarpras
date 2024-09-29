<x-form id="submissionForm" wire:submit.prevent="store" class="space-y-2" autocomplete="off" no-separator>
    <div class="grid w-full grid-cols-1 gap-4">
        <x-choices-offline label="Unit" :options="$users" id="unit_id" wire:model="nip" hint="Please select an item"
            class="w-full" icon="o-radio" inline single searchable />
        <x-textarea label="Perihal" wire:model="regarding" placeholder="Type here ..." rows="3" inline />

        <x-tabs wire:model="selectedItemTab">
            <!-- Tab for Existing Items -->
            <x-tab name="existing-item-tab" label="Barang" icon="o-inbox-stack">
                @foreach ($inputs as $key => $value)
                    <div
                        class="grid w-full gap-4 p-5 my-2 border border-gray-400 border-dashed rounded-md md:grid-cols-6 md:items-center">
                        <div class="col-span-6">
                            <x-choices-offline label="Items" :options="$items" option-label="name"
                                option-sub-label="type" wire:model="inputs.{{ $key }}.item_code"
                                hint="Please select an item" class="w-full" icon="o-radio" inline single searchable />
                        </div>
                        <div class="col-span-4">
                            <x-input type="number" wire:model="inputs.{{ $key }}.qty" class="w-full"
                                icon="o-funnel" min="1" />
                        </div>
                        <div class="col-span-2">
                            <x-button type="button" label="Remove"
                                wire:click.prevent="removeInput({{ $key }})"
                                class="flex w-full btn-ghost btn-outline" icon="o-document-minus" />
                        </div>
                    </div>
                @endforeach
            </x-tab>

            <!-- Tab for New/Custom Items -->
            <x-tab name="new-item-tab" label="Barang baru" icon="o-inbox">
                @foreach ($inputNewItems as $key => $value)
                    <div class="grid w-full gap-4 p-5 border border-gray-400 border-dashed rounded-md">
                        <x-input wire:model="inputNewItems.{{ $key }}.custom_item" class="w-full"
                            icon="o-funnel" placeholder="Enter new item name" />
                        <x-input type="number" wire:model="inputNewItems.{{ $key }}.custom_item_qty" class="w-full"
                            icon="o-funnel" min="1" />
                    </div>
                @endforeach
            </x-tab>
        </x-tabs>


        <x-button type="button" label="Add" icon="o-sparkles" wire:click.prevent="addInput('exist-item')"
            class="mt-5 btn btn-ghost btn-outline" />
    </div>

    <x-slot:actions>
        <x-button label="Submit" icon="c-paper-airplane" class="w-full text-white btn-primary md:w-auto lg:w-auto"
            type="submit" spinner="store" />
    </x-slot:actions>
</x-form>
