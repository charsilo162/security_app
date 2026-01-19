<x-layout.app :title="$service['title']">

    {{-- Navbar --}}
    <x-ui.navbar />

    {{-- Service Detail Section --}}
    <section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
        <div class="max-w-5xl mx-auto px-6">

            {{-- Back link --}}
            <div class="mb-10">
                <a
                    href="{{ route('services') ?? url()->previous() }}"
                    class="inline-flex items-center gap-2 text-sm text-zinc-400 hover:text-red-500 transition"
                >
                    ← Back to Services
                </a>
            </div>

            {{-- Hero --}}
            <div class="grid md:grid-cols-2 gap-14 items-center">

                {{-- Image --}}
                <div class="overflow-hidden rounded-2xl shadow-lg">
                    <img
                        src="{{ $service['image'] }}"
                        alt="{{ $service['title'] }}"
                        class="w-full h-full object-cover"
                    />
                </div>

                {{-- Content --}}
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-6">
                        {{ $service['title'] }}
                    </h1>

                    <p class="text-zinc-300 leading-relaxed text-lg">
                        {{ $service['short'] }}
                    </p>

                    {{-- CTA --}}
                    {{-- <div class="mt-10">
                        <x-buttons.primary-button href="#contact">
                            Request This Service
                        </x-buttons.primary-button>
                    </div> --}}
                </div>

            </div>

            {{-- Divider --}}
            <div class="my-20 border-t border-white/10"></div>

            {{-- What we offer --}}
            <div>
                <h2 class="text-2xl font-semibold mb-8">
                    What This Service Covers
                </h2>

                <div class="grid sm:grid-cols-2 gap-6 text-zinc-300">

                    <div class="flex gap-3">
                        <span class="text-red-500">✔</span>
                        <span>Professional security personnel</span>
                    </div>

                    <div class="flex gap-3">
                        <span class="text-red-500">✔</span>
                        <span>Risk assessment & planning</span>
                    </div>

                    <div class="flex gap-3">
                        <span class="text-red-500">✔</span>
                        <span>24/7 operational readiness</span>
                    </div>

                    <div class="flex gap-3">
                        <span class="text-red-500">✔</span>
                        <span>Rapid incident response</span>
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- Optional: Contact section --}}
    {{-- <x-sections.contact /> --}}

</x-layout.app>
