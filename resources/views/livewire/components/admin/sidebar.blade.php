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
                        <livewire:utils.navLink title="Profile" icon="o-finger-print"
                            link="{{ route('users.show', [$user->id]) }}" />
                        <x-menu-item title="Logout" icon="o-power"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" />
                    </x-dropdown>
                </x-slot>
            </x-list-item>
        @endif

        <x-menu activate-by-route>
            <livewire:utils.navLink title="Dashboard" icon="o-rectangle-group" link="/{{ $user->role }}" />

            <x-menu-sub title="Barang" icon="o-cube" class="text-black" open>
                <livewire:utils.navLink title="Data Barang" icon="o-document-chart-bar"
                    link="{{ route('items.index') }}" />
                <livewire:utils.navLink title="Barang Keluar" icon="o-arrow-up-on-square-stack"
                    link="{{ route('out-items.index') }}" />
                @can('isAdmin')
                    <livewire:utils.navLink title="Barang Masuk" icon="o-arrow-down-on-square-stack"
                        link="{{ route('in-items.index') }}" />
                    <livewire:utils.navLink title="Kategori" icon="o-puzzle-piece" link="{{ route('category.index') }}" />
                @endcan
            </x-menu-sub>

            <x-menu-sub title="Pengajuan" icon="o-tag" open>
                <livewire:utils.navLink title="Pengadaan" icon="o-clipboard-document-list"
                    link="{{ route('submissions.index') }}" />
                <livewire:utils.navLink title="Permintaan" icon="o-chat-bubble-bottom-center-text"
                    link="{{ route('requests.index') }}" />
            </x-menu-sub>

            {{-- <livewire:utils.navLink title="Laporan" icon="o-chart-pie" link="{{ route('stock.index') }}" /> --}}
            
            <x-menu-sub title="Laporan" icon="o-chart-pie" open>
                <livewire:utils.navLink title="Laporam ..." icon="o-chart-bar-square" link="#" />
            </x-menu-sub>

            @can('isAdmin')
            <x-menu-sub title="Kelola Akun" icon="o-tv" open>
                <livewire:utils.navLink title="Supplier" icon="o-truck" link="{{ route('suppliers.index') }}" />
                <livewire:utils.navLink title="Pegawai" icon="o-computer-desktop" link="{{ route('employees.index') }}" />
                <livewire:utils.navLink title="Akun" icon="o-identification" link="{{ route('users.index') }}" />
            </x-menu-sub>
            @endcan
        </x-menu>
    </x-slot:sidebar>
</div>
