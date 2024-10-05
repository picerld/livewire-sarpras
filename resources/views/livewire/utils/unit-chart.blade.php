<x-card title="Transaction" subtitle="{{ $currentTime->monthName }}'s transaction" class="flex h-full" shadow no-separator>
    <x-chart wire:model="chart" class="w-full h-80" />
</x-card>
