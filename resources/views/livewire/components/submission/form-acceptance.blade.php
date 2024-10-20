<div class="flex gap-3">
    @if ($submission->status === 'pending')
        <x-button label="Setujui" wire:click="updateStatus('accepted')" icon="o-check-circle"
            class="text-sm btn-outline btn-sm" spinner />
        <x-button label="Tolak" wire:click="updateStatus('rejected')" icon="o-x-circle"
        class="text-sm btn-outline btn-sm" spinner />
    @else
        <x-button label="Selesai!" icon="o-bolt" class="text-sm text-white bg-dark btn-outline btn-sm" />
    @endif

</div>
