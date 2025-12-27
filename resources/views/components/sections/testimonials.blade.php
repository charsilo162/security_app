<section class="relative py-24 bg-gradient-to-br from-black via-[#0f172a] to-[#1a0f1f] text-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->
        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="text-center max-w-2xl mx-auto transition-all duration-700 ease-out"
        >
            <h2 class="text-3xl md:text-4xl font-bold">
                What Our <span class="text-red-500">Customers Say</span>
            </h2>
            <p class="mt-6 text-zinc-400">
                Trusted by professionals and organizations.
            </p>
        </div>

        <!-- Carousel -->
        <div
            x-data="testimonialCarousel()"
            x-init="
                $nextTick(() => {
                    testimonials = [...$refs.items.children]
                    start()
                })
            "
            class="mt-16 relative"
        >
            <div class="relative overflow-hidden min-h-[420px]">

                <template x-for="(slide, i) in testimonials" :key="i">
                    <div
                        x-show="index === i"
                        x-transition.opacity.duration.700ms
                        class="grid md:grid-cols-2 gap-12 items-center absolute inset-0"
                    >
                        <img
                            :src="slide.dataset.image"
                            class="rounded-2xl h-[420px] w-full object-cover"
                        />

                        <div class="bg-zinc-900/80 border border-zinc-800 rounded-xl p-10">
                            <p class="text-zinc-300 leading-relaxed" x-text="slide.dataset.text"></p>

                            <div class="mt-6">
                                <h4 class="font-semibold" x-text="slide.dataset.name"></h4>
                                <p class="text-sm text-zinc-400" x-text="slide.dataset.role"></p>
                            </div>
                        </div>
                    </div>
                </template>

            </div>

            <!-- Hidden Data -->
            <div x-ref="items" class="hidden">
                <div
                    data-image="/storage/images/d1.jpg"
                    data-text="E-Security handled our event flawlessly. Calm, alert, professional."
                    data-name="Tomi Adebayo"
                    data-role="Event Organizer"
                ></div>

                <div
                    data-image="/storage/images/d2.jpg"
                    data-text="Their team is disciplined and extremely reliable."
                    data-name="James Okorie"
                    data-role="Corporate Manager"
                ></div>
            </div>

            <!-- Controls -->
            <div class="flex justify-center gap-4 mt-10">
                <button @click="prev()" class="w-3 h-3 rounded-full bg-zinc-600 hover:bg-red-600"></button>
                <button @click="next()" class="w-3 h-3 rounded-full bg-zinc-600 hover:bg-red-600"></button>
            </div>
        </div>
    </div>
</section>
