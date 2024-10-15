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

<script>
    window.onscroll = function() {
        const header = document.querySelector("header");
        const fixedNav = header?.offsetTop;
        const toTop = document.querySelector("#to-top");

        if (window.pageYOffset > fixedNav) {
            header?.classList.add("nav-fixed");
            toTop?.classList.remove("hidden");
            toTop?.classList.add("flex");
        } else {
            header?.classList.remove("nav-fixed");
            toTop?.classList.remove("flex");
            toTop?.classList.add("hidden");
        }
    };
</script>

<body class="font-sans antialiased bg-gradient-to-b from-black to-gray-900">
    <div class="relative">
        @if (isset($header))
            <header class="fixed inset-x-0 top-0 z-10 w-full transition-all duration-300 bg-transparent nav-fixed">
                {{ $header }}
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    <x-toast />
</body>

</html>
