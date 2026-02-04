<div class="p-6">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">My Profile</h2>
        <p class="text-zinc-400 text-sm">
            If you find any Erro on you details contact the 
            <a href="{{ route('contact') }} " class="text-zinc-300 text-xl">Admin click HERE</a>
            .</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
            
            <div class="h-2 bg-red-600"></div>

            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
                    
                    {{-- <div class="relative">
                        <img 
                            src="{{ $client['photo'] ?? 'https://ui-avatars.com/api/?name='.$client['first_name'].'+'.$client['last_name'].'&background=ef4444&color=fff' }}" 
                            alt="Profile" 
                            class="w-32 h-32 rounded-2xl object-cover border-4 border-zinc-800 shadow-lg"
                        >
                        <div class="absolute -bottom-2 -right-2 bg-red-600 p-2 rounded-lg text-white text-xs">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div> --}}

                    <div class="flex-1 w-full text-center md:text-left">
                        <h1 class="text-3xl font-bold text-white">{{ $client['first_name'] }} {{ $client['last_name'] }}</h1>
                        <p class="text-red-500 font-medium mb-6">{{ $client['industry'] }} Specialist</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3 text-zinc-300">
                                    <div class="w-8 h-8 rounded bg-zinc-800 flex items-center justify-center text-red-500">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <span>{{ $client['email'] }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-zinc-300">
                                    <div class="w-8 h-8 rounded bg-zinc-800 flex items-center justify-center text-red-500">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <span>{{ $client['phone'] }}</span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center gap-3 text-zinc-300">
                                    <div class="w-8 h-8 rounded bg-zinc-800 flex items-center justify-center text-red-500">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <span>{{ $client['company_name'] }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-zinc-300">
                                    <div class="w-8 h-8 rounded bg-zinc-800 flex items-center justify-center text-red-500">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <span class="font-mono text-sm">{{ $client['registration_number'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-zinc-800">

                <div class="flex flex-wrap justify-between items-center gap-4">
                    <div class="text-zinc-500 text-xs">
                        Member since: <span class="text-zinc-300">{{ $client['created_at'] }}</span>
                    </div>
                    {{-- <div class="flex gap-3">
                        <button class="px-6 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg transition text-sm font-semibold">
                            Edit Profile
                        </button>
                        <button class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm font-semibold shadow-lg shadow-red-900/20">
                            Download Report
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>