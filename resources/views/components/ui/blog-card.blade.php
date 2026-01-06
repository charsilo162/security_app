@props(['post'])
<article class="group relative rounded-2xl overflow-hidden border border-white/10 bg-black/50 transition-all duration-500 hover:-translate-y-2 hover:border-red-500/50">
    <div class="overflow-hidden">
        <img src="{{ $post['image_url'] ?? '/storage/images/placeholder.jpg' }}" class="h-44 w-full object-cover transition duration-700 group-hover:scale-110" />
    </div>
    <div class="p-5">
        <span class="inline-block text-xs bg-red-600 text-white px-3 py-1 rounded-full mb-3">
            {{ $post['categories'][0]['name'] ?? 'Update' }}
        </span>
        <h3 class="text-sm font-semibold leading-snug line-clamp-2">{{ $post['title'] }}</h3>
        <div class="mt-4 text-xs text-zinc-400 flex justify-between">
            <span>{{ \Carbon\Carbon::parse($post['published_at'])->format('M d, Y') }}</span>
        </div>
        <a href="{{ route('blog.show', $post['uuid']) }}" class="mt-4 inline-block text-xs text-red-500 hover:text-white transition">
            Read more →
        </a>
    </div>
</article>