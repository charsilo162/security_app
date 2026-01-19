<section class="relative py-24 bg-gradient-to-br from-black via-zinc-900 to-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16">

        <div x-data="{ infoShown: false }" 
             x-intersect.once="infoShown = true"
             :class="infoShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
             class="transition-all duration-1000 ease-out">
            
            <h2 class="text-3xl md:text-4xl font-bold">
                How to <span class="text-red-500">Contact Us</span>
            </h2>

            <p class="mt-4 text-zinc-400 max-w-md">
                Whether you need a quote, consultation, or urgent response — our team is ready.
            </p>

            <ul class="mt-10 space-y-6 text-zinc-300">
                <li class="flex gap-4">📧 <span>info@e-security.com</span></li>
                <li class="flex gap-4">📞 <span>+234 803 456 7890</span></li>
                <li class="flex gap-4">📍 <span>123 Security Avenue, Lagos, Nigeria</span></li>
            </ul>
        </div>

        <div 
            wire:key="contact-form-card"
            x-data="{ formVisible: false }" 
            x-intersect.once="formVisible = true"
            :class="formVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
            class="transition-all duration-1000 ease-out bg-black/60 border border-zinc-800 rounded-2xl p-10 backdrop-blur hover:-translate-y-1 hover:shadow-[0_25px_50px_-15px_rgba(0,0,0,.7)]"
        >

            @if (session()->has('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-lg animate-pulse">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="sendMessage" class="space-y-6">
                <div>
                    <input type="text" wire:model.blur="name" placeholder="Your Name"
                        class="w-full bg-black border @error('name') border-red-500 @else border-zinc-700 @enderror rounded-lg px-4 py-3 focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-colors" />
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <input type="email" wire:model.blur="email" placeholder="Your Email"
                        class="w-full bg-black border @error('email') border-red-500 @else border-zinc-700 @enderror rounded-lg px-4 py-3 focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-colors" />
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <input type="text" wire:model.blur="subject" placeholder="Subject"
                        class="w-full bg-black border @error('subject') border-red-500 @else border-zinc-700 @enderror rounded-lg px-4 py-3 focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-colors" />
                    @error('subject') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <textarea rows="5" wire:model.blur="message" placeholder="Message"
                        class="w-full bg-black border @error('message') border-red-500 @else border-zinc-700 @enderror rounded-lg px-4 py-3 focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-colors"></textarea>
                    @error('message') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-red-600 hover:bg-red-700 disabled:bg-zinc-700 transition px-8 py-3 rounded-full font-semibold flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="sendMessage">Send Message</span>
                    <span wire:loading wire:target="sendMessage">Processing...</span>
                </button>
            </form>
        </div>
    </div>
</section>