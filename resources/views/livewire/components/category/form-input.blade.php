<x-card class="w-full md:w-1/2 lg:w-1/2">
    <x-header title="Category" subtitle="Add your own category" size="text-2xl" separator />
    <x-form wire:submit="store" autoComplete="false" no-separator>
        <x-input label="Name" wire:model="newCategory.name" inline />

        <x-slot:actions>
            <x-button label="Submit" class="text-white btn-primary hover:opacity-80" type="submit" icon="c-paper-airplane"
                spinner="store" />
        </x-slot:actions>
    </x-form>
</x-card>
