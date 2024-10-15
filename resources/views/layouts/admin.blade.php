<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Sarpras - Sistem Informasi Manajemen Sarana dan Prasarana.">
    <meta name="keywords" content="Sarpras, Manajemen, Sarana, Prasarana, Laravel, Livewire">
    <meta name="author" content="Picerld">

    <title>{{ $title ?? 'Laravel' }} - Sarpras</title>

    <!-- cdn for currency -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"
        defer></script>

    <!-- cdn for rich text TinyMCE -->
    <!-- RICH TEXT EDITOR FOR NEXT FEATURE!! -->
    {{-- <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js"
        referrerpolicy="origin" defer></script> --}}

    <!-- FOR DEVELOPMENT -->
    {{-- <link rel="stylesheet" href="{{ mix('/resources/css/app.css') }}">
    <script src="{{ mix('/resources/js/app.js') }}"></script> --}}

    <!-- PRODUCTION -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="transition-colors duration-300">
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
