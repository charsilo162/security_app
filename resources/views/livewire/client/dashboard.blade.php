<div class="p-6 space-y-8 bg-zinc-50 dark:bg-zinc-950 min-h-screen">
    
    {{-- Top Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight">Console</h1>
            <p class="text-zinc-500 font-medium">Monitoring your corporate security perimeter.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('client.my-requests') }}" class="px-5 py-3 rounded-2xl bg-white dark:bg-zinc-900 border dark:border-zinc-800 text-sm font-bold shadow-sm">
                View History
            </a>
            <a href="{{ route('client.request-service') }}" class="px-5 py-3 rounded-2xl bg-indigo-600 text-white text-sm font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 transition">
                + Request Personnel
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border dark:border-zinc-800 shadow-sm">
            <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4 text-indigo-600">
                <i class="fas fa-user-shield"></i>
            </div>
            <p class="text-zinc-500 text-xs font-bold uppercase tracking-widest">Active Guards</p>
            <h3 class="text-3xl font-black mt-1">{{ $stats['active_guards'] }}</h3>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border dark:border-zinc-800 shadow-sm">
            <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-4 text-amber-600">
                <i class="fas fa-clock"></i>
            </div>
            <p class="text-zinc-500 text-xs font-bold uppercase tracking-widest">Pending Requests</p>
            <h3 class="text-3xl font-black mt-1">{{ $stats['pending_requests'] }}</h3>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border dark:border-zinc-800 shadow-sm">
            <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center mb-4 text-emerald-600">
                <i class="fas fa-check-double"></i>
            </div>
            <p class="text-zinc-500 text-xs font-bold uppercase tracking-widest">Completed Shifts</p>
            <h3 class="text-3xl font-black mt-1">124</h3>
        </div>
    </div>

    {{-- Recent Activity / Active Deployments --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Active Mission Card --}}
        <div class="bg-zinc-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-8">
                    <span class="bg-indigo-500 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">Current Deployment</span>
                    <i class="fas fa-broadcast-tower text-indigo-500 animate-pulse"></i>
                </div>
                
                <h4 class="text-2xl font-bold mb-1">Headquarters Night Shift</h4>
                <p class="text-zinc-400 text-sm mb-6">4 Personnel currently on-site</p>

                <div class="flex -space-x-3 mb-8">
                    <img class="w-12 h-12 rounded-full border-4 border-zinc-900 object-cover" src="https://i.pravatar.cc/150?u=1">
                    <img class="w-12 h-12 rounded-full border-4 border-zinc-900 object-cover" src="https://i.pravatar.cc/150?u=2">
                    <img class="w-12 h-12 rounded-full border-4 border-zinc-900 object-cover" src="https://i.pravatar.cc/150?u=3">
                    <div class="w-12 h-12 rounded-full border-4 border-zinc-900 bg-zinc-800 flex items-center justify-center text-xs font-bold">+1</div>
                </div>

                <button class="w-full py-4 bg-white/10 hover:bg-white/20 rounded-2xl font-bold text-sm transition">
                    Contact Site Supervisor
                </button>
            </div>
            {{-- Abstract background decoration --}}
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-indigo-600/20 rounded-full blur-3xl"></div>
        </div>

        {{-- Request List Preview --}}
        <div class="bg-white dark:bg-zinc-900 rounded-[2rem] border dark:border-zinc-800 p-8 shadow-sm">
            <h4 class="text-lg font-bold mb-6">Recent Request Status</h4>
            <div class="space-y-6">
                @forelse($recentRequests as $req)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-10 bg-indigo-600 rounded-full"></div>
                        <div>
                            <p class="font-bold text-sm">{{ $req['title'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $req['date'] }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black uppercase px-2 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                        {{ $req['status'] }}
                    </span>
                </div>
                @empty
                <p class="text-zinc-500 text-sm italic">No recent requests found.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>