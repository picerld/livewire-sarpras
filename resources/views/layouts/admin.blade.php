<!DOCTYPE html>
<html lang="en" data-theme="light" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Sarpras</title>

    <!-- Chart -->
    {{-- install chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-nav sticky full-width class="h-20">
        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3-bottom-left" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div class="flex">
                <h1 class="text-2xl font-bold">
                    Sarpras
                </h1>
            </div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            <div class="flex">
                <x-theme-toggle class="btn btn-circle btn-ghost" responsive
                    @theme-changed="console.log($event.detail)" />
                <x-button icon="o-bell" link="###" class="relative btn-circle btn-ghost" responsive>
                    <x-badge value="2" class="absolute badge-secondary -right-1 -top-0" />
                </x-button>
            </div>
        </x-slot:actions>
    </x-nav>

    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width class="bg-base-100">
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">

            {{-- User --}}
            @if (auth()->check())
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    <!-- CSRF Protection -->
                </form>

                <x-list-item :item="$user" value="nama" sub-value="email" no-separator no-hover class="pt-2">
                    <x-slot name="actions">
                        <x-dropdown right>
                            <x-slot:trigger>
                                <x-button icon="o-cog-6-tooth" class="btn-circle btn-ghost btn-sm" />
                            </x-slot:trigger>
                            
                            <x-menu-item title="Logout" icon="o-power" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" />
                            <livewire:navlink title="Account" icon="c-user-circle" link="profile" />
                        </x-dropdown>
                    </x-slot>
                </x-list-item>
            @endif
            <x-menu activate-by-route>

                <livewire:navlink title="Dashboard" icon="o-rectangle-group" link="{{ $user->role }}" />
                <x-menu-separator />

                <x-menu-sub title="Barang" icon="o-cube">
                    <livewire:navlink title="Data Barang" icon="o-document-chart-bar" link="barang" />
                    <livewire:navlink title="Barang Masuk" icon="o-arrow-down-on-square-stack" link="barang-masuk" />
                    <livewire:navlink title="Barang Keluar" icon="o-arrow-up-on-square-stack" link="barang-keluar" />
                    <livewire:navlink title="Kategori" icon="o-puzzle-piece" link="kategori" />
                </x-menu-sub>

                <livewire:navlink title="Pengajuan" icon="o-clipboard-document-list" link="pengajuan" />
                <livewire:navlink title="Permintaan" icon="o-chat-bubble-bottom-center-text" link="permintaan" />

                <x-menu-sub title="Stok" icon="o-clipboard-document">
                    <livewire:navlink title="Laporan" icon="o-arrows-right-left" link="stok" />
                    <livewire:navlink title="Opname" icon="o-chart-bar-square" link="opname" />
                </x-menu-sub>

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content class="flex-1 px-6 pt-4 overflow-y-auto md:pt-4 bg-base-200">
            @if (isset($header))
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    {{ $header }}
                </div>
            @endif
            {{ $slot }}
        </x-slot:content>
    </x-main>
</body>

</html>
