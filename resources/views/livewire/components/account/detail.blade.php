<div class="min-h-[76vh]">
    <x-button label="Go back!" link="/users" icon="c-arrow-left-start-on-rectangle" class="mb-4 btn-outline btn-sm"
        spinner />
    <x-card>
        <x-avatar :image="asset($user->employee->avatar ?? $user->username)" class="!w-28">
            <x-slot:title class="pl-2 text-3xl">
                <h3 class="text-2xl">{{ $user->employee->name }}</h3>
            </x-slot:title>

            <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-slate-950/85">
                <div class="flex flex-col">
                    <x-icon name="o-identification" class="w-5 h-5 text-sm" label="{{ $user->nip }}" />
                    <x-icon name="o-key" class="w-5 h-5 text-sm" label="{{ $user->role }}" />
                    <x-icon name="o-at-symbol" class="w-5 h-5 text-sm" label="{{ $user->username }}" />
                </div>
            </x-slot:subtitle>
        </x-avatar>
    </x-card>

    <x-card class="my-4">
        <x-tabs aria-labelledby="tab account" wire:model="selectedTab" active-class="text-white rounded bg-dark"
            label-class="font-semibold" label-div-class="p-2 rounded">
            <x-tab name="users-tab" label="Profile" icon="o-cake" aria-label="tab profile">
                <livewire:components.account.form-profile :userId="$user->id" />
            </x-tab>
            <x-tab name="tricks-tab" icon="o-ticket" label="Histori"
                aria-label="tab stats">
                <livewire:components.account.stats :userId="$user->id" />
            </x-tab>
        </x-tabs>
    </x-card>
</div>
