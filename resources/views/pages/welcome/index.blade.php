<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Sarpras</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="{{ mix('/resources/css/app.css') }}">
    <script src="{{ mix('/resources/js/app.js') }}"></script> --}}

    <!-- PRODUCTION -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <nav class="px-4 lg:px-10 navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a>Item 1</a></li>
                    <li>
                        <a>Parent</a>
                        <ul class="p-2">
                            <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </li>
                    <li><a>Item 3</a></li>
                </ul>
            </div>
            <div class="flex items-center pb-4">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6">
                    <rect width="256" height="256" fill="none"></rect>
                    <line x1="208" y1="128" x2="128" y2="208" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                    <line x1="192" y1="40" x2="40" y2="192" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
                </svg>
                <h4 class="ml-2 text-xl font-bold text-black dark:text-slate-200">Sarpras</h4>
            </div>
        </div>
        <div class="hidden navbar-center lg:flex">
            <ul class="px-1 menu menu-horizontal">
                <li><a>About</a></li>
                <li>
                    <details>
                        <summary>Docs</summary>
                        <ul class="p-2">
                            <li><a>GitHub</a></li>
                        </ul>
                    </details>
                </li>
                <li><a>Support</a></li>
            </ul>
        </div>
        <div class="navbar-end">
            @auth
                <a href="{{ route(Auth::user()->role) }}" class="text-white btn btn-ghost btn-outline bg-dark">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-white btn btn-ghost btn-outline bg-dark">Login</a>
            @endauth
        </div>
    </nav>

    <main>
        <div class="flex flex-col items-center w-full min-h-screen gap-3 p-4 sm:p-10">
            <div class="w-full">
                <div class="border mockup-browser bg-base-300">
                    <div class="mockup-browser-toolbar">
                        <div class="input">https://sarpras-sebelas.com</div>
                    </div>
                    <div class="flex justify-center px-4 py-16 bg-base-200">Welcome!</div>
                </div>
            </div>

            <div class="grid w-full grid-cols-1 gap-4 py-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="mockup-code">
                    <pre data-prefix="$"><code>npm i sarpras@latest</code></pre>
                    <pre data-prefix=">" class="text-warning"><code>installing...</code></pre>
                    <pre data-prefix=">" class="text-success"><code>Done!</code></pre>
                </div>
                <div class="mockup-code">
                    <pre data-prefix="$"><code>yarn add sarpras@latest</code></pre>
                    <pre data-prefix=">" class="text-warning"><code>installing...</code></pre>
                    <pre data-prefix=">" class="text-success"><code>Done!</code></pre>
                </div>
                <div class="mockup-code">
                    <pre data-prefix="$"><code>pnpm i sarpras@latest</code></pre>
                    <pre data-prefix=">" class="text-warning"><code>installing...</code></pre>
                    <pre data-prefix=">" class="text-success"><code>Done!</code></pre>
                </div>
                <div class="mockup-code">
                    <pre data-prefix="$"><code>bun add sarpras@latest</code></pre>
                    <pre data-prefix=">" class="text-warning"><code>installing...</code></pre>
                    <pre data-prefix=">" class="text-success"><code>Done!</code></pre>
                </div>
                <!-- Additional command blocks as needed -->
            </div>
        </div>
    </main>
</body>


</html>
