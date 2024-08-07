<div class="min-h-[76vh]">
    <x-button label="Go back!" link="/users" icon="c-arrow-left-start-on-rectangle"
    class="mb-4 btn-outline btn-sm" spinner />
    <x-card>
        <x-avatar :image="asset($user->employee->avatar)" class="!w-24">

            <x-slot:title class="pl-2 text-3xl">
                <h3 class="text-xl">{{ $user->employee->name }}</h3>
            </x-slot:title>

            <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-gray-500">
                <div class="flex gap-3">
                    <x-icon name="o-identification" label="{{ $user->employee->nip }}" />
                    <x-icon name="o-key" label="{{ $user->role }}" />
                </div>
                <x-icon name="o-at-symbol" label="{{ $user->username }}" />
            </x-slot:subtitle>

        </x-avatar>
    </x-card>
</div>
