<div class="grid grid-cols-1 gap-5 px-10 lg:grid-cols-4 md:grid-cols-2">
    @forelse ($items as $item)
        <x-card title="{{ $item->name }} ({{ $item->type }})" class="my-2 bg-gray-200">
            <h3 class="text-base font-semibold">
                ({{ $item->qty }} {{ $item->unit }})
            </h3>
            <div class="mb-5">
                @if (Str::length($item->description) > 40)
                    {{ Str::limit($item->description, 40) }}
                @else
                    {{ $item->description }}
                @endif
            </div>

            <x-slot:figure>
                <img src="{{ asset('/storage/' . $item->images) }}" height="200" width="230"
                    class="object-cover w-full min-h-40 max-h-40" aria-labelledby="{{ $item->id }}"
                    alt="{{ $item->name }}" />
            </x-slot:figure>
            <x-slot:menu>
                <x-badge value="{{ $item->category->aliases ?? 'null' }}" class="btn-ghost btn-outline" />
            </x-slot:menu>

            <div class="w-full mt-3">
                @auth
                    <x-button icon="o-wrench-screwdriver" label="Pengajuan" class="w-full btn-outline btn-ghost btn-sm"
                        spinner aria-label="save item" />
                @else
                    
                @endauth
            </div>
        </x-card>

    @empty
        <x-alert title="Nothing here!" description="There is no data yet." icon="o-exclamation-triangle"
            class="border-none bg-base-100">
            <x-slot:actions>
                <x-button label="Clear!" link="/in-items" icon="o-x-mark" class="btn-outline" spinner />
            </x-slot:actions>
        </x-alert>
    @endforelse
</div>
