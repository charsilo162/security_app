<section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADER -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-3xl md:text-4xl font-bold">
                Welcome To <span class="text-red-500">Our Blog</span>
            </h1>

            <p class="mt-4 text-zinc-400">
                Stay informed with expert advice, industry insights, and practical tips
                on event security, corporate protection, and personal safety.
            </p>

            <!-- Search -->
            <div class="mt-8 max-w-md mx-auto">
                <input
                    type="text"
                    placeholder="Search..."
                    class="w-full bg-black border border-zinc-800 rounded-full
                           px-5 py-3 text-sm outline-none
                           focus:border-red-600 focus:ring-1 focus:ring-red-600"
                />
            </div>
        </div>

        <!-- BLOG LIST -->
        <div class="space-y-16">

            <!-- BLOG CARD -->
            @foreach ([
                [
                    'image' => '/storage/images/s1.jpg',
                    'title' => 'How Bouncers Ensure a Safe Nightclub Experience',
                    'text'  => 'Professional bouncers do more than control entry — they manage crowds, prevent conflicts, and create a safe environment.',
                    'date'  => '25th August',
                    'read'  => '3 mins'
                ],
                [
                    'image' => '/storage/images/s2.jpg',
                    'title' => 'Top Security Measures Every Office Should Implement',
                    'text'  => 'From access control to emergency protocols, learn essential steps to protect your workplace.',
                    'date'  => '20th August',
                    'read'  => '5 mins'
                ],
                [
                    'image' => '/storage/images/s3.jpg',
                    'title' => 'VIP Protection: Behind the Scenes of Executive Safety',
                    'text'  => 'Discover how professional security teams plan routes, assess risks, and protect high-profile clients.',
                    'date'  => '18th August',
                    'read'  => '4 mins'
                ],
            ] as $post)

                <article
                    class="grid md:grid-cols-2 gap-10 items-center
                           bg-black/50 border border-white/10 rounded-2xl p-6
                           transition-all duration-700 ease-[cubic-bezier(.16,1,.3,1)]
                           hover:-translate-y-1
                           hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,.7)]"
                >

                    <!-- IMAGE -->
                    <div class="overflow-hidden rounded-xl">
                        <img
                            src="{{ $post['image'] }}"
                            alt="{{ $post['title'] }}"
                            class="w-full h-64 object-cover transition-transform duration-700 hover:scale-110"
                        />
                    </div>

                    <!-- CONTENT -->
                    <div>
                        <span class="inline-block text-xs bg-red-600/20 text-red-500 px-3 py-1 rounded-full mb-4">
                            Blog Post
                        </span>

                        <h2 class="text-xl md:text-2xl font-semibold leading-tight">
                            {{ $post['title'] }}
                        </h2>

                        <p class="mt-4 text-zinc-400">
                            {{ $post['text'] }}
                        </p>

                        <div class="flex items-center gap-6 mt-6 text-xs text-zinc-500">
                            <span>{{ $post['date'] }}</span>
                            <span>Read time: {{ $post['read'] }}</span>
                        </div>

                        <!-- BUTTON -->
                        <x-buttons.primary-button class="mt-6">
                            Read Article
                        </x-buttons.primary-button>
                    </div>

                </article>

            @endforeach

        </div>

    </div>
</section>
