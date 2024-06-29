<x-app-layout>
    <style>
        .apexcharts-title-text {
            fill: rgb(243 244 246);
            font-family: 'Sans serif';
        }
        .apexcharts-subtitle-text {
            fill: rgb(243 244 246);
            font-family: 'Sans serif';
        }
    </style>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Chart user !!
                </div>
            </div>
            <div class="mt-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {!! $chart->container() !!}
                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                    {!! $chart->script() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
