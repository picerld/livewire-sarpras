<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Sarpras - Sistem Informasi Manajemen Sarana dan Prasarana.">
    <meta name="keywords" content="Sarpras, Manajemen, Sarana, Prasarana, Laravel, Livewire">
    <meta name="author" content="Picerld">

    <title>{{ config('app.name', 'Laravel') }} - Sarpras</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="transition-colors duration-300">
    <livewire:components.unit.navbar />
    <x-main with-nav full-width>
            <livewire:components.unit.sidebar />
        <x-slot:content class="flex-1 px-6 pt-4 overflow-y-auto md:pt-4">
            @if (isset($header))
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    {{ $header }}
                </div>
            @endif
            {{ $slot }}
        </x-slot:content>
    </x-main>

    <x-toast />

</body>

</html>
