<section 
    x-data="{ 
        open: false, 
        activeService: {},
        openModal(service) {
            this.activeService = service;
            this.open = true;
        }
    }" 
    class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white"
>
    <div class="max-w-7xl mx-auto px-6">

        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="text-center max-w-2xl mx-auto transition-all duration-700 ease-out"
        >
            <h2 class="text-3xl md:text-4xl font-bold">
                Take A Look At <span class="text-red-500">Services We Provide</span>
            </h2>
            <p class="mt-6 text-zinc-400">
                Professional security solutions designed for confidence and control.
            </p>
        </div>

        <div class="mt-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

            @php
                $services = [
                    ['icon'=>'🛡️','title'=>'Professional Bouncers','text'=>'Crowd control specialists ensuring safety and order.', 'details' => 'Our bouncers are trained in de-escalation tactics and physical security for high-traffic venues.'],
                    ['icon'=>'👔','title'=>'VIP Protection','text'=>'Discreet executive & high-profile security services.', 'details' => 'Close protection for high-net-worth individuals, including secure transport and threat assessment.'],
                    ['icon'=>'🎟️','title'=>'Event Security','text'=>'Large-scale event protection and monitoring.', 'details' => 'From music festivals to corporate galas, we manage access control and perimeter safety.'],
                    ['icon'=>'🏢','title'=>'Corporate Security','text'=>'Office guarding and access control systems.', 'details' => 'Complete facility protection including front-desk management and electronic surveillance.'],
                ];
            @endphp

            @foreach ($services as $i => $service)
                <div
                    x-data="reveal"
                    x-intersect.once="show"
                    :style="'transition-delay: {{ $i * 120 }}ms'"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                    class="group bg-zinc-900/80 border border-zinc-800 rounded-xl p-8
                           transition-all duration-700 ease-out
                           hover:border-red-600 hover:-translate-y-2
                           hover:shadow-[0_0_30px_rgba(239,68,68,0.15)]"
                >
                    <div class="text-3xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        {{ $service['icon'] }}
                    </div>

                    <h3 class="font-semibold text-lg">
                        {{ $service['title'] }}
                    </h3>

                    <p class="mt-3 text-zinc-400 text-sm">
                        {{ $service['text'] }}
                    </p>

                    <button 
                        @click="openModal({{ json_encode($service) }})"
                        class="inline-block mt-5 text-red-500 font-medium hover:text-red-400 transition-colors"
                    >
                        Know More →
                    </button>
                </div>
            @endforeach

        </div>
    </div>

    <template x-teleport="body">
        <div 
            x-show="open" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
            style="display: none;"
        >
            <div 
                @click.away="open = false"
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="bg-zinc-950 border border-zinc-800 p-8 rounded-2xl max-w-lg w-full relative shadow-2xl text-white"
            >
                <button @click="open = false" class="absolute top-5 right-5 text-zinc-500 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="text-5xl mb-6" x-text="activeService.icon"></div>
                
                <h3 class="text-2xl font-bold text-white mb-2" x-text="activeService.title"></h3>
                <div class="w-12 h-1 bg-red-600 mb-6"></div>

                <p class="text-zinc-300 leading-relaxed text-lg" x-text="activeService.details || activeService.text"></p>
                
                <div class="mt-8 pt-6 border-t border-zinc-800">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-red-500">Standard Features</h4>
                    <ul class="mt-4 grid grid-cols-2 gap-3 text-sm text-zinc-400">
                        <li class="flex items-center italic">✓ Fully Certified</li>
                        <li class="flex items-center italic">✓ 24/7 Support</li>
                        <li class="flex items-center italic">✓ Rapid Response</li>
                        <li class="flex items-center italic">✓ Vetted Staff</li>
                    </ul>
                </div>

                <button 
                    @click="open = false" 
                    class="mt-10 w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-red-600/20"
                >
                    Close Window
                </button>
            </div>
        </div>
    </template>
</section>