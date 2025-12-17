@props([
    'title',
    'image',
    'description'
])

<div 
    x-data="{ show: false }"
    x-intersect.once="show = true"
    :class="show 
        ? 'opacity-100 translate-y-0' 
        : 'opacity-0 translate-y-8'"
    class="bg-zinc-900 rounded-xl overflow-hidden shadow-lg
           transition-all duration-700 ease-out"
>

    <!-- Image -->
    <img 
        src="{{ $image }}" 
        alt="{{ $title }}" 
        class="h-56 w-full object-cover"
    >

    <!-- Content -->
    <div class="p-6">
        <h3 class="text-xl font-semibold mb-3">
            {{ $title }}
        </h3>

        <p class="text-zinc-400 text-sm leading-relaxed">
            {{ $description }}
        </p>
    </div>
</div>
