<section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADING -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold">
                Weekly <span class="text-red-500">Reads</span>
            </h2>
        </div>

        <!-- GRID -->
        <div class="grid md:grid-cols-2 gap-12">

            @foreach ([
                [
                    'image' => '/storage/images/d1.jpg',
                    'title' => 'Choosing the Right Security Partner for Your Event or Business',
                    'excerpt' => 'Tips on selecting reliable security professionals who meet your needs and exceed expectations.'
                ],
                [
                    'image' => '/storage/images/d2.jpg',
                    'title' => 'Emergency Response Planning: Be Prepared Before It Happens',
                    'excerpt' => 'Learn how risk assessment and preparedness can prevent incidents and protect lives.'
                ],
            ] as $post)

                <!-- CARD -->
                <article
                    class="group rounded-2xl overflow-hidden
                           bg-black/50
                           transition-all duration-700 ease-[cubic-bezier(.16,1,.3,1)]
                           hover:-translate-y-2
                           hover:shadow-[0_25px_60px_-20px_rgba(0,0,0,.8)]"
                >

                    <!-- IMAGE -->
                    <div class="overflow-hidden">
                        <img
                            src="{{ $post['image'] }}"
                            alt="{{ $post['title'] }}"
                            class="h-64 w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                    </div>

                    <!-- CONTENT -->
                    <div class="p-8 text-center">

                        <span class="inline-block text-xs bg-red-600 text-white px-3 py-1 rounded-full mb-4">
                            Event News
                        </span>

                        <h3 class="text-xl font-semibold leading-snug max-w-lg mx-auto">
                            {{ $post['title'] }}
                        </h3>

                        <p class="mt-4 text-sm text-zinc-400 max-w-md mx-auto">
                            {{ $post['excerpt'] }}
                        </p>

                        <div class="mt-6 text-xs text-zinc-500 flex justify-center gap-6">
                            <span>Author name</span>
                            <span>28th August</span>
                            <span>Read time: 3 mins</span>
                        </div>

                        <!-- BUTTON -->
                        <div class="mt-8">
                            <x-buttons.primary>
                                Read Article
                            </x-buttons.primary>
                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    </div>
</section>
