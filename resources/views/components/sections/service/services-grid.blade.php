<section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold">
                Take A Look At <span class="text-red-500">Services We Provide</span>
            </h2>
            <p class="mt-6 text-zinc-400">
                Professional, disciplined, and responsive security services
                tailored for events, corporate environments, and VIP protection.
            </p>
        </div>

        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ([
                [
                    'image' => '/storage/images/d1.jpg',
                    'title' => 'Professional Bouncers',
                    'text'  => 'Highly trained personnel managing access control, crowd behavior, and on-ground safety.'
                ],
                [
                    'image' => '/storage/images/d2.jpg',
                    'title' => 'VIP & Executive Protection',
                    'text'  => 'Discreet, reliable protection for high-profile individuals and executives.'
                ],
                [
                    'image' => '/storage/images/d3.jpg',
                    'title' => 'Event & Crowd Security',
                    'text'  => 'Experienced teams ensuring order, safety, and rapid response during events.'
                ],
                [
                    'image' => '/storage/images/d4.jpg',
                    'title' => 'Corporate & Office Security',
                    'text'  => 'Securing offices, facilities, and business environments with professionalism.'
                ],
                [
                    'image' => '/storage/images/d5.jpg',
                    'title' => 'Access Control & Checkpoint Security',
                    'text'  => 'Strict monitoring of entry points to prevent unauthorized access.'
                ],
                [
                    'image' => '/storage/images/d6.jpg',
                    'title' => 'Emergency & Rapid Response',
                    'text'  => 'Swift, coordinated response to incidents, ensuring safety and control.'
                ],
                [
                    'image' => '/storage/images/d1.jpg',
                    'title' => 'Security Consulting & Risk Assessment',
                    'text'  => 'Identifying risks and planning proactive security strategies.'
                ],
                [
                    'image' => '/storage/images/d2.jpg',
                    'title' => 'Mobile & Temporary Security Teams',
                    'text'  => 'Flexible deployment for short-term or high-demand situations.'
                ],
                [
                    'image' => '/storage/images/d3.jpg',
                    'title' => 'Specialized Security Solutions',
                    'text'  => 'Custom security plans tailored to unique environments.'
                ],
            ] as $service)

                <!-- Card -->
               <div
                            class="group bg-black/60
                                border border-white/10
                                ring-1 ring-white/5
                                rounded-2xl overflow-hidden
                                transition-all duration-700 ease-[cubic-bezier(.16,1,.3,1)]
                                hover:-translate-y-2
                                hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,.8)]"
                        >

                        <!-- Image -->
                        <div class="overflow-hidden">
                            <img
                                src="{{ $service['image'] }}"
                                alt="{{ $service['title'] }}"
                                class="h-52 w-full object-cover transition-transform duration-700
                                    group-hover:scale-110"
                            />
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="font-semibold text-lg mb-3">
                                {{ $service['title'] }}
                            </h3>

                            <p class="text-sm text-zinc-400 leading-relaxed">
                                {{ $service['text'] }}
                            </p>

                            <!-- Button (LEFT aligned) -->
                            <div class="mt-6">
                                <x-buttons.primary-button href="#">
                                    Know More
                                    {{-- <x-buttons.primary> --}}
                                </x-buttons.primary-button>
                            </div>
                        </div>
                    </div>


            @endforeach

        </div>
    </div>
</section>
