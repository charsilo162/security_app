<section 
    x-data="{
        active: 0,
        slides: [
            {
                image: '/storage/images/d2.jpg',
                title: 'Professional Bouncers & Elite Physical Security Services',
                description: 'Providing highly trained bouncers and security personnel for clubs, events, VIP engagements, and corporate spaces.'
            },
            {
                image: '/storage/images/d1.jpg',
                title: 'Trusted Corporate & Event Security',
                description: 'Reliable protection solutions for businesses, VIPs, and high-profile events.'
            },
            {
                image: '/storage/images/d3.jpg',
                title: 'On-Ground Control & Monitoring',
                description: 'Highly disciplined teams ensuring safety, order, and rapid response at all times.'
            },
            {
                image: '/storage/images/d5.jpg',
                title: 'Control & Monitoring',
                description: 'Highly disciplined teams ensuring safety, order, and rapid response at all times.'
            }
        ],
        start() {
            setInterval(() => {
                this.active = (this.active + 1) % this.slides.length
            }, 5000)
        }
    }"
    x-init="start()"
    class="relative min-h-screen overflow-hidden"
>

    <!-- SLIDES -->
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="active === index"
            x-transition.opacity.duration.1000ms
            x-cloak
            class="absolute inset-0"
        >

            <!-- Background Image -->
            <div 
                class="absolute inset-0 bg-cover bg-center"
                :style="`background-image: url('${slide.image}')`"
            ></div>

            <!-- Dark Overlay (improved depth) -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/70"></div>

            <!-- Content -->
            <div class="relative z-10 h-full max-w-7xl mx-auto px-6 flex items-center justify-end">
                
                <!-- Text Panel -->
                <div 
                    class="max-w-xl text-right bg-black/50 backdrop-blur-md p-8 md:p-10 rounded-lg"
                    x-data="{ show: false }"
                    x-init="
                        show = false;
                        setTimeout(() => show = true, 200);
                        $watch('active', () => {
                            show = false;
                            setTimeout(() => show = true, 200);
                        })
                    "
                >

                    <!-- Animated Title -->
                   <h1 class="text-4xl md:text-6xl font-bold leading-tight text-white">
            <template x-for="(word, i) in slide.title.split(' ')" :key="i">
                <span
                    x-data="{ visible: false }"
                    x-init="setTimeout(() => visible = true, i * 120)"
                    :class="visible 
                        ? 'opacity-100 translate-y-0 blur-0' 
                        : 'opacity-0 translate-y-4 blur-sm'"
                    class="inline-block ml-2 transition-all duration-700 ease-out"
                    x-text="word"
                ></span>
            </template>
            </h1>


                    <!-- Description -->
                 <p
                    :class="show 
                        ? 'opacity-100 translate-y-0 blur-0' 
                        : 'opacity-0 translate-y-4 blur-sm'"
                    class="mt-6 text-zinc-200 transition-all duration-700 ease-out delay-300"
                    x-text="slide.description"
                ></p>


                    <!-- Button -->
             <div
                        :class="show 
                            ? 'opacity-100 translate-y-0' 
                            : 'opacity-0 translate-y-3'"
                        class="mt-8 transition-all duration-700 ease-out delay-500"
                    >
                        <x-buttons.primary>Hire Our Team</x-buttons.primary>
            </div>


                </div>
            </div>

        </div>
    </template>

    <!-- LEFT ARROW -->
    <button 
        @click="active = (active - 1 + slides.length) % slides.length"
        class="absolute left-5 top-1/2 -translate-y-1/2 z-20 bg-black/60 hover:bg-black p-3 rounded-full text-white"
    >‹</button>

    <!-- RIGHT ARROW -->
    <button 
        @click="active = (active + 1) % slides.length"
        class="absolute right-5 top-1/2 -translate-y-1/2 z-20 bg-black/60 hover:bg-black p-3 rounded-full text-white"
    >›</button>

    <!-- DOTS -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-3">
        <template x-for="(_, index) in slides" :key="index">
            <button 
                @click="active = index"
                :class="active === index ? 'bg-red-600 scale-110' : 'bg-white/50'"
                class="w-3 h-3 rounded-full transition-all"
            ></button>
        </template>
    </div>

</section>
