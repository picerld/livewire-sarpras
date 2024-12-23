<div>
    <x-slot name="header">
        <livewire:utils.header>
            <div class="flex text-right md:block lg:block">
                <button class="normal-case btn btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true" class="w-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99">
                        </path>
                    </svg>Refresh Data</button><button class="ml-2 normal-case btn btn-ghost btn-sm"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true" class="w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75">
                        </path>
                    </svg>Email Digests
                </button>
            </div>
        </livewire:utils.header>
    </x-slot>

    <div id="stats" class="grid grid-cols-1 gap-4 mt-7 lg:grid-cols-4 md:grid-cols-4">
        <!-- param 'model' for models -->
        <livewire:utils.stats title="Item" model="Item" icon="o-puzzle-piece" />
        <livewire:utils.stats title="In Item" model="IncomingItem" icon="o-arrow-trending-up" />
        <livewire:utils.stats title="Out Item" model="OutgoingItem" icon="o-arrow-trending-down" />
        <livewire:utils.stats title="Pengadaan" model="Submission" icon="o-chart-pie" />
    </div>

    <div id="charts" class="flex flex-wrap w-full gap-4 pt-3 sm:flex-nowrap">
        <!-- dinamis chart -->
        <div class="w-full shadow md:w-3/4 lg:w-3/4">
            <!-- 'type' for type chart -->
            <livewire:utils.transactionChart />
        </div>
        <div class="w-full shadow md:w-1/4 lg:w-1/4">
            <livewire:utils.unitChart />
        </div>
    </div>

    <div id="overview" class="grid grid-cols-1 gap-3 mt-4 lg-grid-cols-2 md:grid-cols-2">
        <livewire:components.admin.items title="Pengadaan" link="submissions" model="Submission" />
        <livewire:components.admin.items title="Permintaan" link="requests" model="Request" />
    </div>

    <div id="user-tabel" class="w-full py-3">
        <livewire:components.admin.list-item />
    </div>

    <livewire:utils.footer />

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
</div>
