<div>
    <section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-3xl md:text-4xl font-bold italic">
                    THE SECURITY <span class="text-red-500 text-5xl not-italic">JOURNAL</span>
                </h1>
                <p class="mt-4 text-zinc-400">Insights, updates, and expert safety protocols from our front lines.</p>
                
                <div class="mt-8 max-w-md mx-auto relative">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search archives..." 
                           class="w-full bg-black border border-zinc-800 rounded-full px-12 py-3 text-sm focus:border-red-600 outline-none transition-all" />
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-zinc-500"></i>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-10">
                @foreach($featuredPosts as $post)
                    <article class="group relative overflow-hidden rounded-2xl bg-zinc-900/30 border border-white/5 p-4 transition hover:border-red-500/30">
                        <div class="overflow-hidden rounded-xl h-80">
                            <img src="{{ $post['image_url'] ?? '/storage/images/d3.jpg' }}" 
                                 class="w-full h-full object-cover transition duration-700 group-hover:scale-110" />
                        </div>
                        <div class="mt-6">
                            <span class="text-red-500 text-xs font-bold uppercase tracking-widest">Featured Story</span>
                            <h2 class="text-2xl font-bold mt-2 group-hover:text-red-500 transition">{{ $post['title'] }}</h2>
                            <p class="mt-3 text-zinc-400 line-clamp-2 text-sm">{{ strip_tags($post['content']) }}</p>
                            <x-buttons.primary-button href="{{ route('blog.show', $post['uuid']) }}" class="mt-6">
                                Read Full Report
                            </x-buttons.primary-button>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-24 bg-zinc-950 text-white min-h-[400px]">
        <div class="max-w-7xl mx-auto px-6">
            
            @forelse($groupedPosts as $month => $posts)
                <div class="mb-20">
                    <div class="flex items-center gap-6 mb-12">
                        <h3 class="text-xl font-bold text-red-500 flex-shrink-0 uppercase tracking-tighter italic">
                            {{ $month }}
                        </h3>
                        <div class="h-px w-full bg-gradient-to-r from-red-500/50 to-transparent"></div>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($posts as $post)
                            <x-ui.blog-card :post="$post" />
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <div class="text-zinc-700 mb-4"><i class="fas fa-folder-open text-6xl"></i></div>
                    <h3 class="text-zinc-400 text-xl">No articles found matching your search.</h3>
                    <button wire:click="$set('search', '')" class="text-red-500 mt-2 hover:underline">Clear search filters</button>
                </div>
            @endforelse

        </div>
    </section>
</div>