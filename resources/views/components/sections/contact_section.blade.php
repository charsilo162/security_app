<section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16">

        <!-- Contact Info -->
        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
            class="transition-all duration-1000 ease-out"
        >
            <h2 class="text-3xl md:text-4xl font-bold">
                How to <span class="text-red-500">Contact Us</span>
            </h2>

            <p class="mt-4 text-zinc-400 max-w-md">
                Whether you need a quote, consultation, or urgent response —
                our team is ready.
            </p>

            <ul class="mt-10 space-y-6 text-zinc-300">
                <li class="flex gap-4">
                    📧 <span>info@e-security.com</span>
                </li>
                <li class="flex gap-4">
                    📞 <span>+234 803 456 7890</span>
                </li>
                <li class="flex gap-4">
                    📍 <span>123 Security Avenue, Lagos, Nigeria</span>
                </li>
            </ul>
        </div>

        <!-- Form -->
            <div
            x-data
            x-intersect.once="$el.classList.add('opacity-100','translate-y-0')"
           class="opacity-0 translate-y-12 transition-all duration-1000 ease-out
            bg-black/60 border border-zinc-800 rounded-2xl p-10 backdrop-blur
            hover:-translate-y-1 hover:shadow-[0_25px_50px_-15px_rgba(0,0,0,.7)]"
            >

            <form class="space-y-6">

                <input
                    type="text"
                    placeholder="Your Name"
                    class="w-full bg-black border border-zinc-700 rounded-lg px-4 py-3
                           focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none"
                />

                <input
                    type="email"
                    placeholder="Your Email"
                    class="w-full bg-black border border-zinc-700 rounded-lg px-4 py-3
                           focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none"
                />

                <input
                    type="text"
                    placeholder="Subject"
                    class="w-full bg-black border border-zinc-700 rounded-lg px-4 py-3
                           focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none"
                />

                <textarea
                    rows="5"
                    placeholder="Message"
                    class="w-full bg-black border border-zinc-700 rounded-lg px-4 py-3
                           focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none"
                ></textarea>

                <button
                    type="submit"
                    class="bg-red-600 hover:bg-red-700 transition
                           px-8 py-3 rounded-full font-semibold"
                >
                    Send Message
                </button>

            </form>
        </div>

    </div>
</section>
