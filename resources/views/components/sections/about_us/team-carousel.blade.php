<section class="relative py-24 bg-black text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->
        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
            class="text-center max-w-2xl mx-auto transition-all duration-1000 ease-out"
        >
            <h2 class="text-3xl md:text-4xl font-bold">
                Our Expert <span class="text-red-500">Team Members</span>
            </h2>
            <p class="mt-6 text-zinc-400">
                Professional. Disciplined. Trusted.
            </p>
        </div>

        <!-- Carousel -->
        <div
            x-data="teamCarousel()"
            x-init="start()"
            class="mt-16 relative"
        >
            <div class="overflow-hidden">
                <div
                    class="flex gap-8 transition-transform duration-1000 ease-[cubic-bezier(.16,1,.3,1)]"
                    :style="`transform: translateX(-${index * 320}px)`"
                >

                    @foreach ([
                        ['name'=>'Albert Dera','img'=>'/storage/images/d01.jpg'],
                        ['name'=>'Philip Martin','img'=>'/storage/images/d2.jpg'],
                        ['name'=>'Austin Wade','img'=>'/storage/images/d3.jpg'],
                        ['name'=>'Ben Parker','img'=>'/storage/images/d5.jpg'],
                        ['name'=>'Olu Parker','img'=>'/storage/images/d4.jpg'],
                        ['name'=>'Ola Parker','img'=>'/storage/images/d02.jpg'],
                        ['name'=>'Charles','img'=>'/storage/images/d03.jpg'],
                    ] as $member)

                        <div
                            class="w-[300px] shrink-0 bg-zinc-900/80 border border-zinc-800
                                   rounded-2xl p-6 text-center
                                   transition-all duration-700
                                   hover:-translate-y-2
                                   hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,.8)]"
                        >
                            <img
                                src="{{ $member['img'] }}"
                                class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-zinc-700"
                            />

                            <h4 class="mt-4 font-semibold">{{ $member['name'] }}</h4>
                            <p class="text-sm text-zinc-400 mt-1">Security Specialist</p>

                            <div class="flex justify-center gap-4 mt-4 text-zinc-400">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>

            <!-- Controls -->
            <div class="flex justify-center gap-6 mt-10">
                <button
                    @click="prev"
                    class="w-10 h-10 rounded-full bg-zinc-800 hover:bg-red-600 transition"
                >‹</button>

                <button
                    @click="next"
                    class="w-10 h-10 rounded-full bg-zinc-800 hover:bg-red-600 transition"
                >›</button>
            </div>
        </div>

    </div>
</section>
