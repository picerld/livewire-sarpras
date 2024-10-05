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
            <livewire:components.landing.header />
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
                        <x-button label="Bergabung 🚀" link="#features"
                            class="mt-10 text-base text-white transition-all duration-300 bg-purple-800 border-none outline-none hover:bg-purple-800/80" />
                        <x-button label="Lihat guide 👀" link="#features"
                            class="mt-10 text-base text-white transition-all duration-300 bg-gray-800 border-none outline-none hover:bg-gray-800/80" />
                    </div>

                    <div
                        class="grid grid-cols-1 px-20 mt-24 text-left gap-x-12 gap-y-8 sm:grid-cols-2 sm:px-0">
                        <livewire:components.landing.card icon="s-computer-desktop" title="Simple dashboard"
                            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, alias." />
                        <livewire:components.landing.card icon="o-chart-bar-square" title="Realtime analytics"
                            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, alias." />
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>