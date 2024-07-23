<x-card :title=$title separator>
    <x-slot:menu>
        <x-button :label=$title link="/{{ $link }}" icon-right="o-arrow-small-right" class="px-5 btn-sm btn btn-ghost"
            responsive aria-label="Show more {{ $title }}" />
    </x-slot:menu>

    @foreach ($datas as $data)
        <x-list-item :item="$data" link="/{{ $link }}/{{ $data->id }}" no-separator>
            <x-slot:avatar>
                <img src="https://picsum.photos/200?x=9987836" height="100" width="100" alt="{{ $data->nama }}"
                    class="rounded-full w-11 avatar" />
            </x-slot:avatar>
            <x-slot:value>{{ $data->nama }}</x-slot:value>
            <x-slot:sub-value>{{ $data->role ?? $data->stok }}</x-slot:sub-value>
        </x-list-item>
    @endforeach
</x-card>