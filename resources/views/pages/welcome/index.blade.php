<x-guest-layout>
    <x-slot name="header">
        <livewire:components.landing.header />
    </x-slot>

    <livewire:components.unit.sidebar />
    
    <!-- MOVE TO LANDING/FEATURES FOR ALL SECTION -->
    <livewire:components.landing.applicationSection />

    <section class="min-h-screen px-10" id="features">
        @auth
            <div class="grid grid-cols-2 gap-6 px-10">
                <livewire:utils.stats title="Pengajuan" model="Submission" icon="o-arrow-trending-up"
                    class="hover:scale-[99%] transition-all duration-200" />
                <livewire:utils.stats title="Permintaan" model="Request" icon="o-arrow-trending-down"
                    class="hover:scale-[99%] transition-all duration-200" />
            </div>
        @endauth

        <div class="py-10 sm:py-16 lg:py-24" id="faq">
            <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">Questions &
                        Answers</h2>
                    <p class="max-w-xl mx-auto mt-4 text-base leading-relaxed text-gray-300">Explore the common
                        questions about Sarana Prasarana!</p>
                </div>

                <div class="grid grid-cols-1 mt-12 md:mt-20 md:grid-cols-2 gap-y-16 gap-x-20">
                    <livewire:components.landing.faqCard question="Bagaimana cara melakukan pengadaan?"
                    answer="Amet minim mollit non deserunt ullamco est sit
                    aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit." />

                    <livewire:components.landing.faqCard question="Bagaimana cara melakukan permintaan?"
                    answer="Amet minim mollit non deserunt ullamco est sit
                    aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit." />

                    <livewire:components.landing.faqCard question="Do you provide discounts?"
                    answer="Amet minim mollit non deserunt ullamco est sit
                    aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit." />

                    <livewire:components.landing.faqCard question="How do you provide support?"
                    answer="Amet minim mollit non deserunt ullamco est sit
                    aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit." />
                </div>

                <div class="flex items-center justify-center mt-12 md:mt-20">
                    <div class="px-8 py-4 text-center bg-gray-800 rounded-full">
                        <p class="text-gray-50">Didn’t find the answer you are looking for?
                            <a href="#"
                                class="text-yellow-300 transition-all duration-200 hover:text-yellow-400 focus:text-yellow-400 hover:underline">Contact
                                our support
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="min-h-screen px-10" id="item">
        <div class="flex flex-col items-start text-start">
            <h2 class="text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">Explore Item's</h2>
            <p class="mt-4 text-base leading-relaxed text-gray-300">Explore the existing items in Sarana Prasarana!</p>
        </div>
        <livewire:components.unit.listItem />
    </section>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('scrollToItem', function () {
                // Scroll to the #item section
                window.location.hash = '#item';
            });
        });
    </script>
</x-guest-layout>
