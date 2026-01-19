<div class="min-h-screen flex items-center justify-center bg-zinc-950 relative overflow-hidden px-4">
    
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px]"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-600/10 rounded-full blur-[120px]"></div>

    <div class="relative w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 bg-zinc-900/50 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden border border-zinc-800">

        <div class="flex flex-col justify-center px-8 py-12 md:px-16 bg-zinc-900/40">
            
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-white tracking-tight mb-2">Welcome Back</h2>
                <p class="text-zinc-400 text-sm">Please enter your details to access your account.</p>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="login" class="space-y-5">
                
                <div class="group relative">
                    <input 
                        type="text"
                        wire:model="email"
                        placeholder=" "
                        class="peer w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-3.5 text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all"
                    />
                    <label class="absolute left-4 top-3.5 text-zinc-500 text-sm transition-all 
                         peer-placeholder-shown:top-3.5
                         peer-placeholder-shown:text-base
                         peer-placeholder-shown:text-zinc-500
                         peer-focus:top-[-10px] 
                         peer-focus:text-xs 
                         peer-focus:text-indigo-400 
                         peer-focus:font-medium
                         bg-zinc-900 px-2 rounded">
                        Email or Username
                    </label>
                    @error('email')
                        <p class="text-red-400 text-xs mt-1.5 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="group relative">
                    <input 
                        type="password"
                        wire:model="password"
                        placeholder=" "
                        class="peer w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-3.5 text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all"
                    />
                    <label class="absolute left-4 top-3.5 text-zinc-500 text-sm transition-all 
                         peer-placeholder-shown:top-3.5
                         peer-placeholder-shown:text-base
                         peer-placeholder-shown:text-zinc-500
                         peer-focus:top-[-10px] 
                         peer-focus:text-xs 
                         peer-focus:text-indigo-400 
                         peer-focus:font-medium
                         bg-zinc-900 px-2 rounded">
                        Password
                    </label>
                </div>

                {{-- <div class="flex justify-end">
                    <a href="#" class="text-xs text-zinc-500 hover:text-indigo-400 transition-colors">Forgot password?</a>
                </div> --}}

                <button 
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Sign In</span>
                    <span wire:loading class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Authenticating...
                    </span>
                </button>

                <p class="text-center text-sm text-zinc-500 pt-4">
                    New here?
                    <a href="{{ route('register') }}" class="text-indigo-400 font-semibold hover:underline decoration-2 underline-offset-4">Create account</a>
                </p>

            </form>
        </div>

        <div class="hidden md:flex flex-col items-center justify-center bg-zinc-800/30 p-12 border-l border-zinc-800">
            <div class="relative">
                <div class="absolute inset-0 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <img 
                    src="{{ asset('storage/img1.png') }}" 
                    class="relative w-80 h-auto object-contain drop-shadow-[0_20px_50px_rgba(79,70,229,0.3)]"
                    alt="Illustration"
                >
            </div>
            <div class="mt-12 text-center">
                <h3 class="text-xl font-semibold text-white">Elevate your skills</h3>
                <p class="text-zinc-400 mt-2 text-sm max-w-[250px]">Join thousands of students and start your professional journey today.</p>
            </div>
        </div>

    </div>
</div>