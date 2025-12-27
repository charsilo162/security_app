<section class="relative py-16 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-start">

        <!-- Image -->
    <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'"
            class="transition-all duration-1000 ease-out"
        >
            <img
                src="{{ asset('storage/images/d4.jpg') }}"
                class="rounded-2xl shadow-2xl object-cover h-[420px] w-full"
                alt="Security Lobby"
            />
    </div>


        <!-- Content -->
        <div
            x-data="{ selected: null }"
            x-intersect.once="$el.classList.add('opacity-100','translate-y-0')"
            class="opacity-0 translate-y-12 transition-all duration-1000 ease-out
                   bg-black/60 border border-zinc-800 rounded-2xl p-10 backdrop-blur"
        >

            <h2 class="text-3xl md:text-4xl font-bold">
                Let Us Know Your <span class="text-red-500">Concern</span>
            </h2>

            <p class="mt-4 text-zinc-400">
                Your safety is our priority. Whether you need advice, a quote,
                or immediate assistance — we’re listening.
            </p>

            <h4 class="mt-8 font-semibold text-lg">
                What do you expect from us?
            </h4>

            <!-- Checklist -->
            <ul class="mt-6 space-y-4">
                @foreach ([
                    'Professional & Direct',
                    'Customer-Focused Communication',
                    'Premium Presentation',
                    'Calm & Respectful Conduct',
                    'Detailed Risk Assessment',
                    'High-End Security Experience'
                ] as $i => $item)
                    <li
                        @click="selected = {{ $i }}"
                        class="flex items-center gap-3 cursor-pointer group"
                    >
                        <span
                            :class="selected === {{ $i }}
                                ? 'bg-red-600 border-red-600'
                                : 'border-zinc-600'"
                            class="w-4 h-4 rounded-full border flex items-center justify-center
                                   transition"
                        >
                            <span x-show="selected === {{ $i }}" class="w-2 h-2 bg-white rounded-full"></span>
                        </span>

                        <span class="text-zinc-300 group-hover:text-white transition">
                            {{ $item }}
                        </span>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</section>
