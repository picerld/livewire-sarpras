<div class="w-full px-2 pb-3 bg-white rounded shadow dark:bg-dark dark:text-slate-300" wire:model="expanded" expandable>
    <x-header wire:model.live="search" title="Users" subtitle="Users Model" class="px-3 pt-3" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input wire:model="search" icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    
    <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/users/{id}"
    class="bg-white rounded dark:bg-dark" with-pagination >
        @scope('cell_role', $users)
            <x-badge :value="$users->role" class="text-base-100 badge-primary" />
         @endscope
    </x-table>

    <x-spotlight /> 
</div>