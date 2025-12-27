<section class="relative py-20 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-start">

        <!-- Image -->
        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'"
            class="transition-all duration-1000 ease-[cubic-bezier(.16,1,.3,1)]"
        >
            <img
                src="/storage/images/d03.jpg"
                class="rounded-2xl shadow-2xl object-cover h-[420px] w-full"
                alt="Security Officers"
            />
        </div>

        <!-- Content -->
        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
            class="transition-all duration-1000 ease-[cubic-bezier(.16,1,.3,1)]"
        >
            <h2 class="text-3xl md:text-4xl font-bold">
                Highly-Trained <span class="text-red-500">Officers</span> That Make A Good Impression
            </h2>

            <p class="mt-6 text-zinc-400 leading-relaxed">
                At E-Security, our officers are more than guards — they are disciplined,
                highly trained professionals who create confidence and reassurance.
            </p>

            <div class="mt-6 space-y-4 text-zinc-400 text-sm leading-relaxed">
                <p>
                    Our team undergoes rigorous training in crowd management,
                    emergency response, conflict resolution, and situational awareness.
                </p>
                <p>
                    Officers maintain a polished appearance and calm demeanor,
                    ensuring guests and clients feel secure at all times.
                </p>
                <p>
                    Every officer is alert, proactive, and ready to respond instantly
                    to potential risks with discretion and authority.
                </p>
            </div>
        </div>

    </div>
</section>
