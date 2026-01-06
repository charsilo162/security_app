<header 
    x-data="{ 
        open: false, 
        scrolled: false 
    }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
    :class="scrolled ? 'bg-black/80 backdrop-blur shadow-lg' : 'bg-transparent'"
    class="fixed top-0 left-0 w-full z-50 transition-all"
>
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center gap-2 font-bold text-xl">
            <img src="/logo.svg" class="h-8" alt="">
            <span>Elite Security</span>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex gap-8 text-sm uppercase">
                @foreach (config('navigation') as $item)
                    <a
                        {{-- Pass the route name AND the params array (default to empty array if missing) --}}
                        href="{{ route($item['route'], $item['params'] ?? []) }}"
                        
                        @class([
                            'transition',
                            'text-red-500 font-semibold' => request()->routeIs($item['route']),
                            'hover:text-red-500 text-zinc-300' => !request()->routeIs($item['route']),
                        ])
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
        </nav>


        <!-- Desktop CTA -->
        <div class="hidden md:block">
        <a href="{{ route('register', ['role' => 'client']) }}">
            <x-buttons.primary>Hire Our Team</x-buttons.primary>
        </a>       
     </div>

        <!-- Mobile Hamburger -->
        <button 
            @click="open = !open"
            class="md:hidden focus:outline-none"
            aria-label="Toggle Menu"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path 
                    x-show="!open" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M4 6h16M4 12h16M4 18h16"
                />
                <path 
                    x-show="open" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu Panel -->
 <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-5"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-5"
            @click.outside="open = false"
            class="md:hidden bg-black/95 backdrop-blur border-t border-zinc-800"
        >

        <nav class="flex flex-col px-6 py-6 space-y-6 text-sm uppercase">
                @foreach (config('navigation') as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @click="open = false"
                        @class([
                            'transition',
                            'text-red-500 font-semibold' => request()->routeIs($item['route']),
                            'hover:text-red-500 text-zinc-300' => !request()->routeIs($item['route']),
                        ])
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <x-buttons.primary class="w-full text-center">
                    Hire Our Team
                </x-buttons.primary>
        </nav>

    </div>
</header>
