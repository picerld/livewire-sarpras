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
                <img src="https://picsum.photos/200?x=9987834" width="30" height="30" alt="{{ $user->nama }}"
                    class="rounded-full w-11 avatar" />
            </x-slot:avatar>
            <x-slot:value>
                {{ $user->name }}
            </x-slot:value>
            <x-slot:sub-value>
                {{ $user->role }}
            </x-slot:sub-value>
            <x-slot:actions>
                <x-button icon="o-trash" class="btn-error btn-outline" wire:click="delete({{ $user->id }})" spinner
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
            {{-- <x-form id="itemsForm" wire:submit="store" class="space-y-4" autocomplete="off" no-separator>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-input wire:model="newItem.name" id="name" label="Name" inline />
                    <x-input wire:model="newItem.merk" id="merk" label="Merk" inline />
                    <x-input wire:model="newItem.unit" id="unit" label="Satuan" inline />
                    <x-input label="Price" wire:model="newItem.price" suffix="Rp" money locale="id-ID" inline />
                    <x-input wire:model="newItem.stock" id="stock" type="number" label="Stok" min="1"
                        inline />
                    <x-input wire:model="newItem.minimum_stock" id="minimum_stock" label="Stok minimum" type="number"
                        min="1" inline />
                    <x-select wire:model="newItem.category_id" id="category" for="Category" label="Category"
                        :options="$categories" inline />
                    <x-file wire:model="newItem.images" accept="image/png" crop-after-change />
                </div>
                <x-textarea label="Deskripsi" wire:model="newItem.description" placeholder="Type here ..."
                    rows="3" inline />

                <x-slot:actions>
                    <x-button label="Submit!" icon="c-paper-airplane" class="text-white btn-primary" type="submit" spinner="store" />
                </x-slot:actions>
            </x-form> --}}
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
