<x-card>
    <x-header wire:model.live.debounce="search" title="Users" subtitle="Users Data" class="px-3 pt-3" separator
        progress-indicator>
        <x-slot:actions>
            <x-input wire:model="search" id="search" icon="o-magnifying-glass" class="placeholder:font-bold"
                placeholder="Search..." autocomplete="off" />
            <x-button icon="o-funnel" label="Filters" badge="0" wire:click="drawerList" responsive />
            <x-button icon-right="m-plus" label="Add" wire:click="userModal"
                class="text-white btn-primary hover:opacity-80" responsive aria-label="create item" />
        </x-slot:actions>
    </x-header>
    @forelse ($users as $user)
        <x-list-item :item="$user" no-separator link="/users/{{ $user->id }}">
            <x-slot:avatar>
                <img src="https://ui.shadcn.com/avatars/01.png" width="30" height="30" alt="{{ $user->nama }}"
                    class="rounded-full w-11 avatar" />
            </x-slot:avatar>
            <x-slot:value>
                {{ $user->employee->name }}
                <x-badge value="{{ $user->role }}" class="btn-ghost btn-outline btn-xs" />
            </x-slot:value>
            <x-slot:sub-value>
                {{ $user->email }}
            </x-slot:sub-value>
            <x-slot:actions>
                <x-button icon="o-bookmark-slash" label="Remove" class="btn-ghost btn-outline btn-sm" wire:click="delete({{ $user->id }})" spinner
                    aria-label="delete user" />
            </x-slot:actions>
        </x-list-item>
    @empty
        <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle"
            class="border-none bg-base-100">
            <x-slot:actions>
                <x-button label="Go back!" link="/users" icon="o-x-mark" class="btn-outline" spinner />
            </x-slot:actions>
        </x-alert>
    @endforelse

    <x-spotlight />

    <x-modal wire:model="createUsers" class="backdrop-blur">
        <p class="text-sm">Press `ESC` or click outside to close.</p>
        <x-card>
            <livewire:components.account.form-input />
        </x-card>
    </x-modal>

    <x-drawer title="Filter" wire:model="drawerIsOpen" class="w-1/2 lg:w-1/3" right separator with-close-button
        close-on-escape>
        <x-form wire:submit="users" no-separator>
            <!-- User Filter -->
            <x-choices label="User" wire:model="selectedRole" :options="$roles" inline single />

            <!-- Date Range Filter -->
            <x-input type="date" label="From Date" wire:model="fromDate" />
            <x-input type="date" label="To Date" wire:model="toDate" />

            <x-slot:actions>
                <x-button label="Clear" wire:click="clear" class="btn btn-ghost btn-outline" />
                <x-button label="Save" class="text-white btn-primary" icon="c-paper-airplane" type="submit"
                    spinner="save" />
            </x-slot:actions>
        </x-form>

    </x-drawer>
</x-card>
