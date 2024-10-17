<x-guest-layout>
    <x-slot name="header">
        <livewire:components.landing.header />
    </x-slot>

    <section class="relative lg:min-h-[800px] pb-10 lg:pt-32 md:pt-32 pt-28">
        <div class="flex flex-col items-start px-10 text-start">
            <h2 class="text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">My Items</h2>
            <p class="mt-4 text-base leading-relaxed text-gray-300">Explore the existing items in Sarana Prasarana!</p>
        </div>

        <livewire:components.cart.listItem />
    </section>

</x-guest-layout>
