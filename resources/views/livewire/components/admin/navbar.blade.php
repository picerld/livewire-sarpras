<x-nav sticky full-width class="h-16">
    <x-slot:brand>
        <label for="main-drawer" class="mr-3 lg:hidden">
            <x-icon name="o-bars-3-bottom-left" class="cursor-pointer" />
        </label>
        <div class="flex pb-4">
            <h4 class="text-2xl font-bold">{{ $brandName }}</h4>
        </div>
    </x-slot:brand>

    <x-slot:actions>
        <div class="flex">
            <x-theme-toggle class="pb-4 btn btn-circle btn-ghost" responsive />
            <x-button icon="o-bell" link="#" class="relative pb-4 btn-circle btn-ghost" responsive>
                <x-badge value="{{ $notificationCount }}" class="absolute badge-secondary -right-1 -top-2" />
            </x-button>
        </div>
    </x-slot:actions>
</x-nav>