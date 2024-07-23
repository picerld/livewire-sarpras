<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Sarpras - Sistem Informasi Manajemen Sarana dan Prasarana.">
    <meta name="keywords" content="Sarpras, Manajemen, Sarana, Prasarana, Laravel, Livewire">
    <meta name="author" content="Nama Anda">

    <title>{{ $title ?? 'Laravel' }} - Sarpras</title>

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <livewire:components.admin.navbar />
    <x-main with-nav full-width class="bg-base-100">
        <livewire:components.admin.sidebar />

        <x-slot:content class="flex-1 px-6 pt-4 overflow-y-auto md:pt-4 bg-base-200">
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