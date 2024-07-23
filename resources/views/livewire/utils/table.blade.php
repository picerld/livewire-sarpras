<x-card>
    <x-header wire:model.live.debounce="search" title="Users" subtitle="Users Model" class="px-3 pt-3"
        progress-indicator>
        <x-slot:actions>
            <x-input wire:model="search" icon="o-magnifying-glass" class="placeholder:font-bold" placeholder="Search..." />
            <x-button icon="o-funnel" label="Filters" badge="0" wire:click="tableDrawer" responsive />
        </x-slot:actions>
    </x-header>

    <!-- USING TABLE -->
    <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/users/{id}"
        class="bg-white rounded dark:bg-dark" with-pagination>
        @scope('cell_role', $users)
            <x-badge :value="$users->role" class="text-base-100 badge bg-accent" />
        @endscope
        @scope('actions', $user)
            <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
        @endscope
    </x-table>

    <x-spotlight />

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="users" no-separator>
            {{-- wire:model="name" --}}
            <x-input label="Role" inline />

            <x-slot:actions>
                <x-button label="Cancel" class="btn btn-ghost btn-outline" />
                <x-button label="Click me!" class="text-white btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</x-card>
