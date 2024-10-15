<x-nav sticky full-width class="h-20 bg-white">
    <x-slot:brand class="flex">
        <label for="main-drawer" class="mr-3 lg:hidden">
            <x-icon name="o-bars-3-bottom-left" class="cursor-pointer" />
        </label>
        <div class="flex pb-4">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6">
                <rect width="256" height="256" fill="none"></rect>
                <line x1="208" y1="128" x2="128" y2="208" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                <line x1="192" y1="40" x2="40" y2="192" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
            </svg>
            <h4 class="text-xl font-bold text-black dark:text-slate-200">{{ $brandName }}</h4>
        </div>

        <div class="mx-auto">
            <h1>tes</h1>
        </div>
    </x-slot:brand>

    <x-slot:actions>
        <x-dropdown>
            <x-slot:trigger>
                <x-button icon="o-user" class="btn-circle btn-outline" />
            </x-slot:trigger>

            <x-menu-item title="Logout" icon="o-power" class="btn-outline"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" />
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                <!-- CSRF Protection -->
            </form>
        </x-dropdown>
    </x-slot:actions>
</x-nav>
