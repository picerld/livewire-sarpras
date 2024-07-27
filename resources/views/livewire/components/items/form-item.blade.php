<div>
    <x-header title="Update {{ $item->name }}" separator />

    <x-form id="updateItemForm" wire:submit="save" class="space-y-4" autocomplete="off">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <x-input wire:model="newItem.name" id="name" label="Name" inline />
            <x-input wire:model="newItem.merk" id="merk" label="Merk" inline />
            <x-input wire:model="newItem.unit" id="unit" label="Unit" inline />
            <x-input label="Price" wire:model="newItem.price" suffix="Rp" money locale="id-ID" inline />
            <x-input wire:model="newItem.stock" id="stock" type="number" label="Stock" min="1" inline />
            <x-input wire:model="newItem.minimum_stock" label="Stok Minimum" id="minimum_stock" type="number"
                min="1" inline />
        </div>
        <x-select wire:model="newItem.category_id" id="category" for="Category" label="Category" :options="$categories"
            inline />
        <x-textarea label="Deskripsi" wire:model="newItem.description" rows="3"
            inline />
        <x-slot:actions>
            <x-button label="Cancel" class="btn-outline" link="/items" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit"
                class="text-white btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
