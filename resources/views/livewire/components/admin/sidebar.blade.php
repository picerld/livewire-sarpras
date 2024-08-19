<div>
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-white dark:bg-dark">
        @if (auth()->check())
            <form id="logout-form" class="hidden" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
            
            <x-list-item :item="$user" no-separator no-hover class="pt-2 text-black dark:text-slate-100">
                <x-slot:avatar>
                    <img src="{{ asset($user->employee->avatar) }}" width="30" height="30" alt="{{ $user->name }}"
                        class="rounded-full w-11 avatar" />
                </x-slot:avatar>
                <x-slot:value>
                    {{ $user->employee->name }}
                </x-slot:value>
                <x-slot:sub-value>
                    <p class="text-black dark:text-slate-300">
                        {{ $user->username }}
                    </p>
                </x-slot:sub-value>
                <x-slot name="actions">
                    <x-dropdown right>
                        <x-slot:trigger>
                            <x-button id="setting" aria-label="Setting" icon="o-cog-6-tooth"
                                class="btn-circle btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <livewire:utils.navlink title="Profile" icon="o-finger-print" link="{{ route('users.show', [$user->id]) }}" />
                        <x-menu-item title="Logout" icon="o-power"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" />
                    </x-dropdown>
                </x-slot>
            </x-list-item>
        @endif

        <x-menu activate-by-route>
            <livewire:utils.navlink title="Dashboard" icon="o-rectangle-group" link="/{{ $user->role }}" />

            @can('isAdmin')
                <x-menu-sub title="Barang" icon="o-cube" class="text-black">
                    <livewire:utils.navlink title="Data Barang" icon="o-document-chart-bar"
                        link="{{ route('items.index') }}" />
                    <livewire:utils.navlink title="Barang Masuk" icon="o-arrow-down-on-square-stack"
                        link="{{ route('in-items.index') }}" />
                    <livewire:utils.navlink title="Barang Keluar" icon="o-arrow-up-on-square-stack" link="barang-keluar" />
                    <livewire:utils.navlink title="Kategori" icon="o-puzzle-piece" link="{{ route('category.index') }}" />
                </x-menu-sub>
            @endcan

            <livewire:utils.navlink title="Pengajuan" icon="o-clipboard-document-list" link="{{ route('submissions.index') }}" />
            <livewire:utils.navlink title="Permintaan" icon="o-chat-bubble-bottom-center-text" link="permintaan" />

            <x-menu-sub title="Stok" icon="o-clipboard-document">
                <livewire:utils.navlink title="Laporan" icon="o-chart-pie" link="{{ route('stock.index') }}" />
                {{-- <livewire:utils.navlink title="Opname" icon="o-chart-bar-square" link="opname" /> --}}
            </x-menu-sub>

            @can('isAdmin')
                <livewire:utils.navlink title="Akun" icon="o-identification" link="{{ route('users.index') }}" />
            @endcan
        </x-menu>
    </x-slot:sidebar>
</div>
