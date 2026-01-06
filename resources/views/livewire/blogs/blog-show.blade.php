<div class="bg-black min-h-screen text-white pb-24">
    <div class="relative h-[60vh] w-full">
        <img src="{{ $post['image_url'] ?? '/storage/images/d3.jpg' }}" 
             class="w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 w-full p-6 md:p-20">
            <div class="max-w-4xl mx-auto">
                <div class="flex gap-2 mb-4">
                    @foreach($post['categories'] as $cat)
                        <span class="bg-red-600 text-white text-[10px] uppercase font-bold px-3 py-1 rounded-full">
                            {{ $cat['name'] }}
                        </span>
                    @endforeach
                </div>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight">{{ $post['title'] }}</h1>
                <div class="flex items-center gap-6 mt-6 text-zinc-400 text-sm">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-red-500"></i>
                        {{ \Carbon\Carbon::parse($post['published_at'])->format('F d, Y') }}
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-user text-red-500"></i>
                        Admin
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 mt-12">
        <div class="prose prose-invert prose-red max-w-none text-zinc-300 leading-relaxed">
            {!! $post['content'] !!}
        </div>

        <div class="mt-16 pt-8 border-t border-zinc-800 flex flex-wrap justify-between items-center gap-6">
            <a href="{{ route('blog') }}" class="text-zinc-400 hover:text-red-500 flex items-center gap-2 transition">
                <i class="fas fa-arrow-left"></i> Back to Blog
            </a>
            
            <div class="flex gap-4">
                <span class="text-zinc-500 text-sm italic">Share this article:</span>
                <button class="text-zinc-400 hover:text-white transition"><i class="fab fa-facebook"></i></button>
                <button class="text-zinc-400 hover:text-white transition"><i class="fab fa-twitter"></i></button>
                <button class="text-zinc-400 hover:text-white transition"><i class="fab fa-linkedin"></i></button>
            </div>
        </div>
    </div>
</div>