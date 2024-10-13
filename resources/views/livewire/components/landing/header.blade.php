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
            <a href="#" title=""
                class="text-base text-white transition-all duration-200 hover:text-gray-300">Home</a>

            <a href="#" title=""
                class="text-base text-white transition-all duration-200 hover:text-gray-300">Pengadaan</a>

            <a href="#" title=""
                class="text-base text-white transition-all duration-200 hover:text-gray-300">Permintaan</a>

            <a href="#" title=""
                class="text-base text-white transition-all duration-200 hover:text-gray-300">Riwayat</a>
        </div>

        <form id="logout-form" class="hidden" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>

        <!-- Right side login/auth items -->
        <div class="lg:flex lg:items-center lg:justify-end lg:space-x-6 sm:ml-auto">
            @auth
                <a href="{{ route(Auth::user()->role) }}"
                    class="inline-flex items-center justify-center px-3 sm:px-5 py-2.5 text-sm sm:text-base font-semibold transition-all duration-200 text-white bg-gray-600 hover:bg-gray-700 focus:bg-gray-700 rounded-lg"
                    role="button">Profil</a>
                <x-button icon="o-power"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" />
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-10 py-1.5 text-sm font-semibold text-white transition-all duration-200 bg-gray-800 rounded-md sm:text-base hover:bg-gray-900/95 focus:bg-gray-900/95"
                    role="button">Login</a>
            @endauth
        </div>

        <!-- Mobile menu button -->
        <button type="button" name="mobile-menu" aria-label="mobile-menu"
            class="inline-flex p-2 ml-1 text-white transition-all duration-200 rounded-md sm:ml-4 lg:hidden focus:bg-gray-800 hover:bg-gray-800">
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
