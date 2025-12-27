<section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->
        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown
                ? 'opacity-100 translate-y-0'
                : 'opacity-0 translate-y-8'"
            class="text-center max-w-2xl mx-auto transition-all duration-700 ease-out"
        >
            <h2 class="text-3xl md:text-4xl font-bold">
                Take A Look At <span class="text-red-500">Services We Provide</span>
            </h2>
            <p class="mt-6 text-zinc-400">
                Professional security solutions designed for confidence and control.
            </p>
        </div>

        <!-- Services Grid -->
        <div class="mt-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

            @php
                $services = [
                    ['icon'=>'🛡️','title'=>'Professional Bouncers','text'=>'Crowd control specialists ensuring safety and order.'],
                    ['icon'=>'👔','title'=>'VIP Protection','text'=>'Discreet executive & high-profile security services.'],
                    ['icon'=>'🎟️','title'=>'Event Security','text'=>'Large-scale event protection and monitoring.'],
                    ['icon'=>'🏢','title'=>'Corporate Security','text'=>'Office guarding and access control systems.'],
                ];
            @endphp

            @foreach ($services as $i => $service)
                <div
                    x-data="reveal"
                    x-intersect.once="show"
                    :style="'transition-delay: {{ $i * 120 }}ms'"
                    :class="shown
                        ? 'opacity-100 translate-y-0'
                        : 'opacity-0 translate-y-10'"
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

                    <span class="inline-block mt-5 text-red-500 font-medium">
                        Know More →
                    </span>
                </div>
            @endforeach

        </div>
    </div>
</section>
