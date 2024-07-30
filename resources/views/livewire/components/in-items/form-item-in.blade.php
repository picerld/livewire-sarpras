<x-form id="itemsForm" wire:submit.prevent="store" class="space-y-4" autocomplete="off" no-separator>
    <div class="grid w-full grid-cols-1 gap-4">

        <!-- Supplier Selection (outside of loop) -->
        <div class="mb-4">
            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
            <select id="supplier_id" wire:model="supplier_id" class="form-select">
                <option value="">Select Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
            @error('supplier_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    
        <!-- Dynamic Inputs Loop -->
        @foreach ($inputs as $key => $value)
            <div class="flex items-center mb-4 space-x-2">
                <x-select label="Items" :options="$items" wire:model="inputs.{{ $key }}.item_id" inline />
                <input type="number" wire:model="inputs.{{ $key }}.qty" class="w-full form-input" placeholder="Qty">
                <button type="button" wire:click.prevent="removeInput({{ $key }})" class="btn btn-danger">Remove</button>
                @error('inputs.' . $key . '.item_id')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
                @error('inputs.' . $key . '.qty')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        @endforeach
        
        <button type="button" wire:click.prevent="addInput" class="btn btn-success">Add Input</button>
    </div>
    
    <x-slot:actions>
        <x-button label="Submit" class="text-white btn-primary" type="submit" spinner="save" />
    </x-slot:actions>
</x-form>
