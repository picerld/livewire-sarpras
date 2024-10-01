<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Sarpras - Sistem Informasi Manajemen Sarana dan Prasarana.">
    <meta name="keywords" content="Sarpras, Manajemen, Sarana, Prasarana, Laravel, Livewire">
    <meta name="author" content="Picerld">

    <title>Laravel - Sarpras</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="{{ mix('/resources/css/app.css') }}">
    <script src="{{ mix('/resources/js/app.js') }}"></script> --}}

    <!-- PRODUCTION -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-gray-400">
    <div class="relative bg-gradient-to-b from-black to-gray-900">
        <header class="absolute inset-x-0 top-0 z-10 w-full">
            <div class="px-4 mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <div class="flex-shrink-0 mr-3">
                        <a href="#" title="" class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6 text-white">
                                <rect width="256" height="256" fill="none"></rect>
                                <line x1="208" y1="128" x2="128" y2="208" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="16"></line>
                                <line x1="192" y1="40" x2="40" y2="192" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="16"></line>
                            </svg>
                            <h4 class="text-xl font-semibold text-white">Sarpras</h4>
                        </a>
                    </div>

                    <!-- Centered navigation links -->
                    <div class="flex-grow hidden lg:flex lg:items-center lg:justify-center lg:space-x-10">
                        <a href="#" title=""
                            class="text-base text-white transition-all duration-200 hover:text-gray-300">Features</a>

                        <a href="#" title=""
                            class="text-base text-white transition-all duration-200 hover:text-gray-300">Solutions</a>

                        <a href="#" title=""
                            class="text-base text-white transition-all duration-200 hover:text-gray-300">Resources</a>

                        <a href="#" title=""
                            class="text-base text-white transition-all duration-200 hover:text-gray-300">Pricing</a>
                    </div>

                    <!-- Right side login/auth items -->
                    <div class="lg:flex lg:items-center lg:justify-end lg:space-x-6 sm:ml-auto">
                        @auth
                            <a href="{{ route(Auth::user()->role) }}"
                                class="inline-flex items-center justify-center px-3 sm:px-5 py-2.5 text-sm sm:text-base font-semibold transition-all duration-200 text-white bg-gray-600 hover:bg-gray-700 focus:bg-gray-700 rounded-lg"
                                role="button">Dashboard</a>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <!-- Menu open: "block", Menu closed: "hidden" -->
                        <svg class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </header>

        <section class="relative lg:min-h-[800px] pb-10 lg:pt-48 md:pt-32 pt-40">
            <div class="relative z-20 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-xl mx-auto text-center">
                    <h1 class="text-6xl font-bold">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white"><span
                                class="text-purple-800">Sarana</span> Prasarana
                        </span>
                    </h1>
                    <p class="mt-5 text-base text-gray-300 sm:text-xl">No more hassle taking loans and making payments.
                        Try
                        Postcrats credit card, make your life simple.</p>

                    <div class="flex justify-center gap-5">
                        <x-button label="Bergabung 🚀" link="{{ route('login') }}"
                            class="mt-10 text-base text-white transition-all duration-300 bg-purple-800 border-none outline-none hover:bg-purple-800/80" />
                        <x-button label="Lihat guide 👀" link="#features"
                            class="mt-10 text-base text-white transition-all duration-300 bg-gray-800 border-none outline-none hover:bg-gray-700" />
                    </div>

                    <div id="features"
                        class="grid grid-cols-1 px-20 mt-12 text-left gap-x-12 gap-y-8 sm:grid-cols-3 sm:px-0">
                        <div class="flex items-center">
                            <svg class="flex-shrink-0" width="31" height="25" viewBox="0 0 31 25"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M25.1667 14.187H20.3333C17.6637 14.187 15.5 16.3507 15.5 19.0203V19.8258C15.5 19.8258 18.0174 20.6314 22.75 20.6314C27.4826 20.6314 30 19.8258 30 19.8258V19.0203C30 16.3507 27.8363 14.187 25.1667 14.187Z"
                                    stroke="gray" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M18.7227 6.9369C18.7227 4.71276 20.5263 2.90912 22.7504 2.90912C24.9746 2.90912 26.7782 4.71276 26.7782 6.9369C26.7782 9.16104 24.9746 11.7702 22.7504 11.7702C20.5263 11.7702 18.7227 9.16104 18.7227 6.9369Z"
                                    stroke="gray" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M13.2231 15.8512H7.11157C3.73595 15.8512 1 18.5871 1 21.9628V22.9814C1 22.9814 4.18311 24 10.1674 24C16.1516 24 19.3347 22.9814 19.3347 22.9814V21.9628C19.3347 18.5871 16.5988 15.8512 13.2231 15.8512Z"
                                    fill="black" stroke="gray" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M9.52788 9.81462C11.752 9.81462 13.5556 8.011 13.5556 5.78683C13.5556 3.56266 11.752 1.75903 9.52788 1.75903C7.30371 1.75903 5.50008 3.56266 5.50008 5.78683C5.50008 8.011 7.30371 9.81462 9.52788 9.81462Z"
                                    fill="black" stroke="gray" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="ml-5 text-lg text-gray-200">Simple dashboard</p>
                        </div>

                        <div class="flex items-center">
                            <svg class="flex-shrink-0" width="26" height="26" viewBox="0 0 26 26"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.71877 1H15.4693C20.8434 1 24.6877 5.84431 24.6877 11.2185C24.6877 16.5926 20.8434 21.4369 15.4693 21.4369H9.71877C4.34461 21.4369 0.500305 16.5926 0.500305 11.2185C0.500305 5.84431 4.34461 1 9.71877 1Z"
                                    stroke="gray" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M9.71882 8.06543C9.71882 7.72125 9.98977 7.45032 10.3339 7.45032H14.8532C15.1974 7.45032 15.4683 7.72125 15.4683 8.06543V12.5847C15.4683 12.9288 15.1974 13.1998 14.8532 13.1998H10.3339C9.98977 13.1998 9.71882 12.9288 9.71882 12.5847V8.06543Z"
                                    fill="black" stroke="gray" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M8.07568 7.78296C7.9809 7.94757 7.92426 8.1334 7.91266 8.32743C7.88635 8.85206 8.1019 9.33069 8.50292 9.64208L10.095 10.8422C10.4594 11.123 10.7165 11.5395 10.8055 12.0265L11.1496 13.9095C11.2302 14.3684 11.5933 14.7006 12.0564 14.7006H12.8251C13.2882 14.7006 13.6513 14.3684 13.7319 13.9095L14.076 12.0265C14.1651 11.5395 14.4221 11.123 14.7865 10.8422L16.3786 9.64208C16.7796 9.33069 16.9952 8.85206 16.9688 8.32743C16.9572 8.1334 16.9006 7.94757 16.8058 7.78296L15.9185 6.30483C15.6889 5.91291 15.3065 5.62106 14.8622 5.50289L12.9246 4.9754C12.4616 4.84913 11.9818 4.84913 11.5188 4.9754L9.5812 5.50289C9.1369 5.62106 8.75446 5.91291 8.5249 6.30483L7.63765 7.78296Z"
                                    fill="black" stroke="gray" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <p class="ml-5 text-lg text-gray-200">Top security</p>
                        </div>

                        <div class="flex items-center">
                            <svg class="flex-shrink-0" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.9998 8C20.9998 7.73478 20.8943 7.48043 20.707 7.29289C20.5195 7.10536 20.2651 7 19.9998 7H9.99976L8.60976 3.516C8.52104 3.29338 8.35611 3.10817 8.14571 2.99176C7.93531 2.87535 7.69106 2.834 7.45376 2.875H3.99976C3.73453 2.875 3.48018 2.98043 3.29265 3.16797C3.10512 3.3555 2.99976 3.60985 2.99976 3.875V18.125C2.99976 18.3902 3.10512 18.6446 3.29265 18.8321C3.48018 19.0196 3.73453 19.125 3.99976 19.125H7.45376C7.69106 19.166 7.93531 19.1247 8.14571 19.0082C8.35611 18.8918 8.52104 18.7066 8.60976 18.484L9.99976 15H19.9998C20.2651 15 20.5195 14.8946 20.707 14.7071C20.8943 14.5196 20.9998 14.2652 20.9998 14V8Z"
                                    stroke="gray" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M22 11H19.3333" stroke="gray" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <p class="ml-5 text-lg text-gray-200">Real-time data</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</body>

</html>
