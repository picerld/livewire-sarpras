<x-card title="{{ $title }}" separator class="shadow">
    @if ($datas->isEmpty())
        <x-alert title="Nothing here!" class="bg-base-100" description="Try to remove some filters."
            icon="o-exclamation-triangle" />
    @else
        <x-slot:menu>
            <x-button label="Show More" link="/{{ $link }}" icon-right="m-arrow-small-right"
                class="px-5 text-white btn-sm btn btn-outline bg-dark" responsive aria-label="Show more submissions" />
        </x-slot:menu>

        @foreach ($datas as $data)
            <x-list-item :item="$data" link="/{{ $link }}/{{ $data->id }}" no-separator>
                <x-slot:avatar>
                    <img src="{{ asset($data->users->avatar) }}" height="100" width="100"
                        alt="{{ $data->users->name }}" class="rounded-full w-11 avatar" />
                </x-slot:avatar>
                <x-slot:value>
                    <div class="flex justify-between">
                        {{ $data->users->name }}
                        <x-badge value="{{ $data->status }}" class="btn-outline" />
                    </div>
                </x-slot:value>
                <x-slot:sub-value>
                    <p class="text-black dark:text-slate-300">
                        @if (Str::length($data->regarding) > 25)
                            {{ Str::limit($data->regarding, 25) }}
                        @else
                            {{ $data->regarding }}
                        @endif
                    </p>
                </x-slot:sub-value>
            </x-list-item>
        @endforeach
    @endif
</x-card>
