<x-nav sticky full-width class="h-16 bg-white dark:bg-dark">
    <x-slot:brand>
        <label for="main-drawer" class="mr-3 lg:hidden">
            <x-icon name="o-bars-3-bottom-left" class="cursor-pointer" />
        </label>
        <div class="flex pb-4">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6"><rect width="256" height="256" fill="none"></rect><line x1="208" y1="128" x2="128" y2="208" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="192" y1="40" x2="40" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line></svg>
            <h4 class="text-xl font-bold text-black dark:text-slate-200">{{ $brandName }}</h4>
        </div>
    </x-slot:brand>

    <x-slot:actions>
        <div class="flex">
            <x-theme-toggle class="pb-4 btn btn-circle btn-ghost" responsive />
            <x-button icon="o-bell" link="#" class="relative pb-4 btn-circle btn-ghost" responsive>
                <x-badge value="{{ $notificationCount }}" class="absolute text-white badge-neutral -right-1 -top-2" />
            </x-button>
        </div>
    </x-slot:actions>
</x-nav>