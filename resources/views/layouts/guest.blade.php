<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Login - ' . 'Sarpras' }}</title>

    <!-- CHANGE THE ICON -->
    <link rel="icon" href="{{ asset('avatars/04.png') }}">

    <!-- !!! DEPLOYMENT !!! -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0">
        {{-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
                </a>
            </div> --}}

        <div class="w-full overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
