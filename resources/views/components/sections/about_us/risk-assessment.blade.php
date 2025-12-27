<section class="relative py-20 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADING (FULL WIDTH) -->
        <div
            x-data="reveal"
            x-intersect.once="show"
            :class="shown
                ? 'opacity-100 translate-y-0'
                : 'opacity-0 translate-y-10'"
            class="text-center max-w-3xl mx-auto transition-all duration-1000
                   ease-[cubic-bezier(.16,1,.3,1)]"
        >
            <h2 class="text-3xl md:text-4xl font-bold leading-tight">
                Prepared For Anything:
                <span class="text-red-500">Risk Assessment</span> And
                <span class="text-red-500">Emergency Prevention</span>
            </h2>

            <!-- SMALL DESCRIPTION BELOW HEADING -->
            <p class="mt-5 text-zinc-400 text-sm md:text-base leading-relaxed">
                At E-Security, we anticipate potential threats before they escalate,
                ensuring every environment remains secure, controlled, and prepared.
            </p>
        </div>

        <!-- TWO COLUMN CONTENT -->
        <div class="mt-16 grid md:grid-cols-2 gap-16 items-center">

            <!-- TEXT COLUMN -->
            <div
                x-data="reveal"
                x-intersect.once="show"
                :class="shown
                    ? 'opacity-100 translate-x-0'
                    : 'opacity-0 -translate-x-10'"
                class="transition-all duration-1000
                       ease-[cubic-bezier(.16,1,.3,1)]"
            >
                <div class="space-y-6 text-zinc-400 text-sm leading-relaxed">

                    <p>
                        Before any assignment, our team conducts a comprehensive evaluation
                        of venues, offices, or VIP environments. This includes identifying
                        entry and exit points, crowd flow, vulnerable areas, and potential hazards.
                    </p>

                    <p>
                        We design tailored security strategies that minimize exposure to risk,
                        prevent disruptions, and maintain smooth operations throughout the event
                        or assignment.
                    </p>

                    <p>
                        In emergency situations, our officers respond instantly using
                        structured protocols to manage incidents calmly and effectively,
                        protecting people, assets, and reputation.
                    </p>

                </div>
            </div>

            <!-- IMAGE COLUMN -->
            <div
                x-data="reveal"
                x-intersect.once="show"
                :class="shown
                    ? 'opacity-100 translate-x-0'
                    : 'opacity-0 translate-x-10'"
                class="transition-all duration-1000
                       ease-[cubic-bezier(.16,1,.3,1)]"
            >
                <img
                    src="/storage/images/d02.jpg"
                    alt="Risk Assessment and Emergency Prevention"
                    class="rounded-2xl shadow-2xl object-cover w-full h-[420px]
                           transition-all duration-700
                           hover:scale-[1.03]"
                />
            </div>

        </div>
    </div>
</section>
