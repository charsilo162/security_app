<section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADING -->
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-bold">
                Recent <span class="text-red-500">Posts</span>
            </h2>

            <!-- CATEGORY TABS -->
            <div class="flex flex-wrap justify-center gap-6 mt-8 text-sm text-zinc-400">
                <button class="px-4 py-1 rounded-full bg-red-600 text-white">All</button>
                <button class="hover:text-white transition">Category</button>
                <button class="hover:text-white transition">Category</button>
                <button class="hover:text-white transition">Category</button>
                <button class="hover:text-white transition">Category</button>
            </div>
        </div>

        <!-- POSTS GRID -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

            @foreach ([
                'How to Keep Your Event Safe with Professional Bouncers',
                'Top Corporate Security Measures Every Office Should Implement',
                'VIP Protection: What It Really Takes to Keep High-Profile Clients Safe',
                'The Importance of Rapid Response Teams in Emergencies',
                'The Latest Security Technology You Should Know About',
                'How to Conduct a Risk Assessment for Your Event or Business',
                'What It Takes to Protect High-Profile Clients',
                'Top Security Measures Every Office Should Implement',
            ] as $post)

                <!-- CARD -->
                <article
                    class="group relative rounded-2xl overflow-hidden
                           border border-white/40
                           bg-black/50
                           transition-all duration-700 ease-[cubic-bezier(.16,1,.3,1)]
                           hover:-translate-y-2
                           hover:border-white
                           hover:shadow-[0_0_0_1px_rgba(255,255,255,0.9),0_25px_60px_-20px_rgba(0,0,0,0.8)]"
                >   

                    <!-- IMAGE -->
                    <div class="overflow-hidden">
                        <img
                            src="/storage/images/d3.jpg"
                            alt="{{ $post }}"
                            class="h-44 w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                    </div>

                    <!-- CONTENT -->
                    <div class="p-5">

                        <span class="inline-block text-xs bg-red-600 text-white px-3 py-1 rounded-full mb-3">
                            Event News
                        </span>

                        <h3 class="text-sm font-semibold leading-snug">
                            {{ $post }}
                        </h3>

                        <div class="mt-4 text-xs text-zinc-400 flex justify-between">
                            <span>Aug 30, 2021</span>
                            <span>By Jane Doe</span>
                        </div>

                        <x-buttons.primary
                            href="#"
                            class="mt-4 text-xs px-4 py-1"
                        >
                            Read more
                        </x-buttons.primary>

                    </div>

                </article>

            @endforeach

        </div>

        <!-- VIEW MORE -->
        <div class="text-center mt-16">
            <x-buttons.primary class="px-10">
                View More
            </x-buttons.primary>
        </div>

    </div>
</section>
