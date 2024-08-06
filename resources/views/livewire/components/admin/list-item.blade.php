<x-card class="shadow">
    <x-header wire:model.live.debounce="search" title="Users" subtitle="Users Model" class="px-3 pt-3" separator
        progress-indicator>
        <x-slot:actions>
            <x-input wire:model="search" icon="o-magnifying-glass" class="placeholder:font-bold" placeholder="Search..." />
        </x-slot:actions>
    </x-header>
    <div class="bg-white rounded dark:bg-dark">
        @forelse ($users as $user)
            <x-list-item :item="$user" :link="url('/users/' . $user->id)">
                <x-slot:avatar>
                    <img src="{{ asset($user->employee->avatar) }}" width="44" height="44" alt="{{ $user->nama }}"
                        class="rounded-full w-11 avatar" />
                </x-slot:avatar>
                <x-slot:value>{{ $user->nama ?? $user->employee->name }}
                    <x-badge :value="$user->role" class="btn-ghost btn-outline" />
                </x-slot:value>
                <x-slot:sub-value>
                    <p class="text-black dark:text-slate-300">
                        {{ $user->email }}
                    </p>
                </x-slot:sub-value>
            </x-list-item>
        @empty
            <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle"
                class="border-none bg-base-100">
                <x-slot:actions>
                    <x-button label="Clear filters" wire:click="clear" icon="o-x-mark" class="btn-outline" spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </div>

</x-card>
