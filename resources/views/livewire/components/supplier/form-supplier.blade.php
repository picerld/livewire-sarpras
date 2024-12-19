<div class="min-h-[85vh]">
    <div class="flex flex-col justify-between w-full md:flex-row">
        <x-header title="{{ $supplier->name }}" size="text-3xl" />
        <x-button icon="o-document-minus" wire:click="delete({{ $supplier->id }})" label="Remove"
            class="text-white btn-outline bg-dark" spinner aria-label="delete item" />
    </div>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-1">
            <x-card title="Hello!" class="min-h-[70vh]">
                Explore our supplier

                <x-slot:figure>
                    <img src="{{ asset('img/submission.webp') }}" alt="submission" />
                </x-slot:figure>
                <x-slot:menu>
                    <x-button icon="o-share" class="btn-circle btn-sm" />
                    <x-icon name="o-heart" class="cursor-pointer" />
                </x-slot:menu>
                <x-slot:actions>
                    <x-button link="{{ route('suppliers.index') }}" label="Let's go 👀"
                        class="text-white btn-outline btn-sm bg-dark" />
                </x-slot:actions>
            </x-card>
        </div>
        <div class="col-span-2">
            <x-form id="updateItemForm" wire:submit="save" class="space-y-4" autocomplete="off"
                class="grid grid-flow-row gap-3 auto-rows-min">
                <div class="grid gap-8">
                    <!-- Details Section -->
                    <div class="p-4 bg-white rounded-lg dark:bg-dark">
                        <x-header title="Details" size="text-2xl" separator />
                        <div class="grid grid-cols-1 gap-4">
                            <x-input wire:model="newSupplier.name" id="name" label="Name" inline />
                            <x-textarea label="Description" wire:model="newSupplier.address" rows="3" inline />
                        </div>
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="flex justify-end mt-4 space-x-4">
                    <x-button label="Cancel" class="btn-outline" link="/suppliers" />
                    <x-button label="Save" icon="c-paper-airplane" spinner="save" type="submit"
                        class="text-white dark:text-slate-200 hover:opacity-80 btn-primary" />
                </div>
            </x-form>
        </div>
    </div>
</div>
