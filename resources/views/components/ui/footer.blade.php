<footer class="relative bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <!-- TOP DIVIDER -->
        <div class="h-px bg-zinc-800 mb-12"></div>

        <!-- FOOTER GRID -->
        <div class="grid md:grid-cols-3 gap-14 items-center">

            <!-- LEFT: LEGAL -->
            <div class="space-y-4 text-zinc-400 text-sm">
                <h4 class="text-white font-semibold mb-3">Legal</h4>
                <a href="#" class="block hover:text-red-500 transition">Privacy Policy</a>
                <a href="#" class="block hover:text-red-500 transition">Terms & Conditions</a>
                <a href="#" class="block hover:text-red-500 transition">About Us</a>
            </div>

            <!-- CENTER: LOGO + SOCIAL -->
            <div class="flex flex-col items-center gap-5">

                <!-- LOGO -->
                <img
                    src="/storage/images/lo1.jpg"
                    alt="NSG Security"
                    class="h-12"
                />

                <!-- SOCIAL ICONS -->
                <div class="flex gap-6 text-zinc-500 text-2xl">
                    <a
                        href="#"
                        class="transition-all duration-300 hover:text-white hover:-translate-y-1"
                    >
                        🐦
                    </a>
                    <a
                        href="#"
                        class="transition-all duration-300 hover:text-white hover:-translate-y-1"
                    >
                        📸
                    </a>
                    <a
                        href="#"
                        class="transition-all duration-300 hover:text-white hover:-translate-y-1"
                    >
                        💼
                    </a>
                </div>
            </div>

            <!-- RIGHT: NAVIGATION -->
            <div class="space-y-4 text-zinc-400 text-sm md:text-right">
                <h4 class="text-white font-semibold mb-3">Navigation</h4>
                <a href="/" class="block hover:text-red-500 transition">Home</a>
                <a href="/blog" class="block hover:text-red-500 transition">Blog</a>
                <a href="/calculate" class="block hover:text-red-500 transition">Calculate</a>
                <a href="/team" class="block hover:text-red-500 transition">Our Team</a>
            </div>

        </div>

        <!-- BOTTOM DIVIDER -->
        <div class="h-px bg-zinc-800 my-10"></div>

        <!-- COPYRIGHT -->
        <div class="text-center text-xs text-zinc-500">
            © {{ date('Y') }} NSG Security. All rights reserved.
        </div>
    </div>
</footer>
