<!DOCTYPE html>
<html lang="en" data-theme="light" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Sarpras</title>
    <style>
        .image {
            width: 120px;
            height: 120px;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center min-h-screen px-6 py-24 bg-white sm:py-32 lg:px-8">
    <div class="text-center">
        <p class="text-base font-semibold text-red-600">505</p>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Oops, something went wrong</h1>
        <p class="mt-6 text-base leading-7 text-gray-600">Sorry, we couldn't integrate with your request.</p>
        <div class="flex items-center justify-center mt-10 gap-x-6">
            <a href="/admin"
                class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go
                back</a>
            <a href="#" class="text-sm font-semibold text-gray-900">Contact support <span
                    aria-hidden="true">&rarr;</span></a>
        </div>
    </div>
</body>

</html>
