<x-card>
    <x-header wire:model.live="search" title="Users" subtitle="Users Model" class="px-3 pt-3" separator progress-indicator>
        <x-slot:actions>
            <x-input wire:model="search" icon="o-magnifying-glass" placeholder="Search..." clearable />
            <x-button icon="o-funnel" label="Filters" badge="0" wire:click="tableDrawer" responsive />
        </x-slot:actions>
    </x-header>
    
    <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/users/{id}"
    class="bg-white rounded dark:bg-dark" with-pagination >
        @scope('cell_role', $users)
            <x-badge :value="$users->role" class="text-base-100 badge bg-accent" />
        @endscope
    </x-table>

    <x-spotlight /> 


    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button close-on-escape>
        <x-form wire:submit="save" no-separator>
            <x-input label="Name" wire:model="name" inline />
         
            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</x-card>