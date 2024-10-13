<x-guest-layout>
    <section class="relative lg:min-h-[800px] pb-10 lg:pt-48 md:pt-32 pt-40">
        <div class="relative z-20 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="max-w-xl mx-auto text-center">
                <h1 class="text-6xl font-bold">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white"><span
                            class="text-purple-800">Sarana</span> Prasarana
                    </span>
                </h1>
                <p class="mt-5 text-base text-gray-300 sm:text-xl">Manage your facilities and infrastructure with
                    ease using Sarana Prasarana. Streamline operations and stay productive effortlessly.
                </p>
                <div class="flex justify-center gap-5">
                    <a href="#faq"
                        class="mt-10 text-base text-white transition-all duration-300 bg-purple-800 border-none outline-none btn hover:bg-purple-800/80">
                        Let's Start 🚀</a>
                    <a href="#faq" responsive
                        class="mt-10 text-base text-white transition-all duration-300 bg-gray-800 border-none outline-none btn hover:bg-gray-800/80">
                        Lihat guide 👀</a>
                </div>

                <div class="grid grid-cols-1 px-20 mt-24 text-left gap-x-12 gap-y-8 sm:grid-cols-2 sm:px-0">
                    <livewire:components.landing.card icon="s-computer-desktop" title="Simple dashboard"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, alias." />
                    <livewire:components.landing.card icon="o-chart-bar-square" title="Realtime analytics"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, alias." />
                </div>
            </div>
        </div>
    </section>

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
                    <div class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-white">Bagaimana cara melakukan pengadaan?</p>
                            <p class="mt-4 text-base text-gray-400">Amet minim mollit non deserunt ullamco est sit
                                aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-white">Bagaimana cara melakukan permintaan?</p>
                            <p class="mt-4 text-base text-gray-400">Amet minim mollit non deserunt ullamco est sit
                                aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-white">Do you provide discounts?</p>
                            <p class="mt-4 text-base text-gray-400">Amet minim mollit non deserunt ullamco est sit
                                aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full">
                            <span class="text-lg font-semibold text-white">?</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-white">How do you provide support?</p>
                            <p class="mt-4 text-base text-gray-400">Amet minim mollit non deserunt ullamco est sit
                                aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-12 md:mt-20">
                    <div class="px-8 py-4 text-center bg-gray-800 rounded-full">
                        <p class="text-gray-50">Didn’t find the answer you are looking for?
                            <a href="#" title=""
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
        <livewire:components.unit.listItem />
    </section>
</x-guest-layout>
