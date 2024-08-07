<x-card :title=$title separator class="shadow">
    @if ($datas->isEmpty())
        <x-alert title="Nothing here!" class="bg-base-100" description="Try to remove some filters." icon="o-exclamation-triangle" />
    @else
        <x-slot:menu>
            <x-button :label=$title link="/{{ $link }}" icon-right="o-arrow-small-right"
                class="px-5 btn-sm btn btn-ghost" responsive aria-label="Show more {{ $title }}" />
        </x-slot:menu>

        @foreach ($datas as $data)
            <x-list-item :item="$data" link="/{{ $link }}/{{ $data->id }}" no-separator>
                <x-slot:avatar>
                    <img src="{{ $data->images ? asset('storage/' . $data->images) : asset($data->employee->avatar) }}"
                        height="100" width="100" alt="{{ $data->name }}" class="rounded-full w-11 avatar" />
                </x-slot:avatar>
                <x-slot:value>{{ $data->name ?? $data->employee->name }}</x-slot:value>
                <x-slot:sub-value>
                    <p class="text-black dark:text-slate-300">
                        {{ $data->role ?? $data->stock }}
                    </p>
                </x-slot:sub-value>
            </x-list-item>
        @endforeach
    @endif
</x-card>
