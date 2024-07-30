<div>

    <div class="flex flex-col justify-between w-full md:flex-row">
        <x-header title="{{ $item->name }}" size="text-3xl" />
        <x-button icon="o-trash" wire:click="delete({{ $item->id }})" label="Delete" class="btn-error" spinner
            aria-label="delete item" />
    </div>
    <x-form id="updateItemForm" wire:submit="save" class="space-y-4" autocomplete="off"
        class="grid grid-flow-row gap-3 auto-rows-min">
        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Details Section -->
            <div class="p-4 bg-white rounded-lg dark:bg-dark">
                <x-header title="Details" size="text-2xl" separator />
                <div class="grid grid-cols-1 gap-4">
                    <x-input wire:model="newItem.name" id="name" label="Name" inline />
                    <x-input wire:model="newItem.merk" id="merk" label="Brand" inline />
                    <x-input wire:model="newItem.unit" id="unit" label="Satuan" inline />
                    <x-choices label="Category" wire:model="newItem.category_id" :options="$categories" inline single />
                    <x-input label="Price" wire:model="newItem.price" suffix="Rp" money locale="id-ID" inline />
                    <x-input wire:model="newItem.stock" id="stock" type="number" label="Stock" min="1"
                        inline />
                    <x-input wire:model="newItem.minimum_stock" id="minimum_stock" type="number" label="Minimum Stock"
                        min="1" inline />
                    <x-textarea label="Description" wire:model="newItem.description" rows="3" inline />
                </div>
            </div>
            
            <div class="grid content-start gap-8">
                <div class="bg-white rounded-lg dark:bg-dark">
                    <h2 class="p-5 text-lg font-semibold ">Images</h2>
                    <div class="flex items-center justify-center h-full">
                        <!-- Placeholder for image -->
                        <div class="flex items-center gap-5 flex-col justify-start w-full h-[50vh]">
                            <x-file wire:model="newItem.images" accept="image/png, image/jpeg, image/jpg"
                                crop-after-change>
                                <img src="{{ asset('/storage/' . $item->images) }}"
                                    height="200" width="230" aria-labelledby="{{ $item->id }}"
                                    alt="{{ $item->name }}" />

                            </x-file>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js?v=20240729" defer></script>
                            <link rel="stylesheet"
                                href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
                            <span class="text-xs">Click to change | Max 1MB</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg dark:bg-dark">
                    <h2 class="p-5 text-lg font-semibold ">Cover</h2>
                    <div class="flex items-center justify-center h-full">
                        <!-- Placeholder for cover image -->
                        <div class="flex items-center justify-center w-full h-[40vh]">
                            <span>Click to change | Max 1MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="flex justify-end mt-4 space-x-4">
            <x-button label="Cancel" class="btn-outline" link="/items" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit"
                class="text-white dark:text-slate-200 hover:opacity-80 btn-primary" />
        </div>
    </x-form>
</div>
