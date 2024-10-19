<div class="px-4 mx-auto sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 lg:h-20">
        <div class="flex-shrink-0 mr-3">
            <a href="#" title="" class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6 text-white">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="208" y1="128" x2="128" y2="208" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="192" y1="40" x2="40" y2="192" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                </svg>
                <h4 class="ml-2 text-xl font-semibold text-white">Sarpras</h4>
            </a>
        </div>

        <!-- Centered navigation links -->
        <div class="flex-grow hidden lg:flex lg:items-center lg:justify-center lg:space-x-10">
            <a href="{{ route(Auth::check() ? Auth::user()->role : 'dashboard') }}"
                class="text-base text-white transition-all duration-200 hover:text-gray-300 {{ request()->routeIs('unit') ? 'font-semibold' : '' }}">Home</a>

            <a href="{{ route('submissions.index') }}"
                class="text-base text-white transition-all duration-200 hover:text-gray-300 {{ request()->routeIs('submissions.index') ? 'font-semibold' : '' }}">Pengadaan</a>

            <a href="{{ route('requests.index') }}"
                class="text-base text-white transition-all duration-200 hover:text-gray-300 {{ request()->routeIs('requests.index') ? 'font-semibold' : '' }}">Permintaan</a>

            <a href="#" class="text-base text-white transition-all duration-200 hover:text-gray-300">Riwayat</a>
        </div>

        <form id="logout-form" class="hidden" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>

        <!-- Right side login/auth items -->
        <div class="lg:flex lg:items-center lg:justify-end lg:space-x-2 sm:ml-auto">
            @auth
                <x-button icon="o-shopping-cart" link="{{ route('carts.index') }}" aria-label="cart"
                    class="inline-flex items-center justify-center text-sm font-semibold text-white transition-all duration-200 bg-gray-900 border-none rounded-md px-7 btn-sm sm:text-base hover:bg-gray-900/95">
                    <x-badge value="{{ $value }}" class="text-white border-none bg-accent indicator-item {{ $value > 0 ? '' : 'hidden' }}" />
                </x-button>
                {{-- <a href="{{ route(Auth::user()->role) }}"
                    class="inline-flex items-center justify-center px-3 sm:px-5 py-2.5 text-sm sm:text-base font-semibold transition-all duration-200 text-white bg-gray-600 hover:bg-gray-700 focus:bg-gray-700 rounded-lg"
                    role="button">Profil</a> --}}
                <x-button icon="o-power" aria-label="logout"
                    class="inline-flex items-center justify-center text-sm font-semibold text-black transition-all duration-200 bg-white border-none rounded-md px-7 btn-sm sm:text-base hover:bg-gray-200"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" />
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-10 py-1.5 text-sm font-semibold text-white transition-all duration-200 bg-gray-800 rounded-md sm:text-base hover:bg-gray-900/95"
                    role="button">Login</a>
            @endauth
        </div>

        <label for="main-drawer" class="mr-3 lg:hidden">
            <x-icon name="o-bars-3-bottom-left" class="cursor-pointer" />
        </label>
    </div>
</div>
