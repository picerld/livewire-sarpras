<x-nav sticky full-width class="h-16 bg-white dark:bg-dark">
    <x-slot:brand>
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
    </x-slot:brand>

    <x-slot:actions>
        <div class="flex">
            <x-theme-toggle class="pb-4 btn btn-circle btn-ghost" aria-label="change theme" responsive />
            <div class="relative">
                <x-badge value="{{ $notif }}"
                    class="absolute top-0 right-0 text-white transform translate-x-1/2 -translate-y-1/2 badge-neutral dark:badge-primary" />
                <x-dropdown icon="o-bell" class="relative pb-4 btn-circle btn-ghost" right>
                    <div class="w-72">
                        @foreach ($submissions as $submission)
                            <x-list-item :item="$submission" no-separator>
                                <x-slot:avatar>
                                    <img src="{{ $submission->users->avatar }}"
                                        alt="{{ $submission->users->name }}'s avatar"
                                        class="object-cover w-10 h-10 rounded-full">
                                </x-slot:avatar>
                                <x-slot:value>
                                    {{ $submission->users->name }}
                                </x-slot:value>
                                <x-slot:sub-value>
                                    <p class="font-semibold text-dark/70">
                                        @if (Str::length($submission->regarding) > 5)
                                            <!-- handle for too long description -->
                                            {{ Str::limit($submission->regarding, 5) }}
                                        @else
                                            {{ $submission->regarding }}
                                        @endif
                                    </p>
                                </x-slot:sub-value>
                            </x-list-item>
                        @endforeach
                    </div>
                </x-dropdown>
            </div>
        </div>
    </x-slot:actions>
</x-nav>