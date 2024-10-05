<x-form id="itemsForm" wire:submit.prevent="store" class="space-y-2" autocomplete="off" no-separator>
    <div class="grid w-full grid-cols-1 gap-4">
        <div class="mb-4">
            <x-choices-offline label="Supplier" id="supplierId" :options="$suppliers" wire:model="supplierId" single inline
                hint="Please select a supplier" icon="o-truck" error-field="supplierId" searchable />
        </div>

        <!-- Dynamic Inputs Loop -->
        @foreach ($inputs as $key => $value)
            <div
                class="grid w-full gap-4 p-5 border border-gray-400 border-dashed rounded-md md:grid-cols-6 md:items-center">
                <div class="col-span-6">
                    <x-choices-offline label="Items" :options="$items" option-label="name" option-sub-label="type"
                        wire:model="inputs.{{ $key }}.item_code" hint="Please select an item" class="w-full"
                        icon="o-radio" inline single searchable />
                </div>
                <div class="col-span-4">
                    <x-input type="number" wire:model="inputs.{{ $key }}.qty" class="w-full" icon="o-funnel"
                        min="1" />
                </div>
                <div class="col-span-2">
                    <x-button type="button" label="Remove" wire:click.prevent="removeInput({{ $key }})"
                        class="flex w-full btn-ghost btn-outline" icon="o-document-minus" />
                </div>
            </div>
        @endforeach

        <x-button type="button" label="Add" icon="o-sparkles" wire:click.prevent="addInput"
            class="mt-5 btn btn-ghost btn-outline" />
    </div>

    <x-slot:actions>
        <x-button label="Submit" icon="c-paper-airplane" class="w-full text-white btn-primary md:w-auto lg:w-auto"
            type="submit" spinner="store" />
    </x-slot:actions>
</x-form>
