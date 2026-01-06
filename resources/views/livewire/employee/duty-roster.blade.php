<div class="p-4 md:p-8 max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-black text-zinc-900 dark:text-white uppercase tracking-tight">Duty Roster</h1>
        <p class="text-zinc-500 text-sm">Your upcoming security assignments and deployments.</p>
    </div>

    <div class="space-y-4">
        @forelse($assignments as $job)
            <div class="bg-white dark:bg-zinc-900 border dark:border-zinc-800 rounded-3xl p-6 shadow-sm hover:shadow-md transition group">
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    
                    {{-- 1. MISSION MAIN INFO --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full {{ $job['status'] === 'active' ? 'bg-green-500 animate-pulse' : 'bg-zinc-300' }}"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">{{ $job['category'] }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white group-hover:text-indigo-600 transition">
                            {{ $job['title'] }}
                        </h3>

                        {{-- CLIENT NAME --}}
                        <p class="text-sm text-zinc-700 dark:text-zinc-300 mt-2 flex items-center gap-2 font-semibold">
                            <i class="fas fa-building text-xs text-zinc-400"></i> 
                            {{ $job['client_name'] }}
                        </p>

                        {{-- LOCATION INFO (Placed here for context) --}}
                        <p class="text-sm text-zinc-500 mt-1 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-xs text-red-500"></i> 
                            {{ $job['location'] }}
                        </p>
                    </div>

                    {{-- 2. SCHEDULE INFO --}}
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl p-4 flex flex-row md:flex-col items-center justify-between md:justify-center min-w-[160px]">
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-zinc-400 uppercase">Reporting Date</p>
                            <p class="font-bold text-zinc-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($job['start_date'])->format('d M, Y') }}
                            </p>
                            <p class="text-[10px] font-medium text-zinc-500">
                                {{ \Carbon\Carbon::parse($job['start_date'])->format('H:i A') }}
                            </p>
                        </div>
                        
                        <div class="h-px w-8 md:w-full bg-zinc-200 dark:bg-zinc-700 my-2"></div>
                        
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-zinc-400 uppercase">Status</p>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-black uppercase tracking-tighter 
                                {{ $job['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-indigo-100 text-indigo-700' }}">
                                {{ $job['status'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- 3. ACTIONS AREA --}}
                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between border-t dark:border-zinc-800 pt-4 gap-4">
                    <div class="flex items-center gap-4">
                        {{-- BRIEFING BUTTON --}}
                        <button onclick="alert('MISSION BRIEFING:\n\n{{ addslashes($job['briefing']) }}')" 
                            class="text-sm font-bold text-zinc-900 dark:text-white hover:text-indigo-600 flex items-center gap-2 transition">
                            <i class="fas fa-info-circle text-indigo-500 text-lg"></i> 
                            View Briefing
                        </button>
                    </div>
                    
                   {{-- 3. ACTIONS AREA --}}
<div class="mt-6 flex flex-col sm:flex-row items-center justify-between border-t dark:border-zinc-800 pt-4 gap-4">
    <div class="flex items-center gap-4">
        {{-- BRIEFING BUTTON --}}
        <button onclick="alert('MISSION BRIEFING:\n\n{{ addslashes($job['briefing']) }}')" 
            class="text-sm font-bold text-zinc-900 dark:text-white hover:text-indigo-600 flex items-center gap-2 transition">
            <i class="fas fa-info-circle text-indigo-500 text-lg"></i> 
            View Briefing
        </button>
    </div>
    
    {{-- LOGIC: Show different UI based on Confirmation and Status --}}
    <div class="w-full sm:w-auto text-right">
        @if($job['is_confirmed'])
            {{-- State 1: Guard has already clicked the button --}}
            <div class="flex items-center gap-2 text-emerald-600 font-bold text-xs bg-emerald-50 dark:bg-emerald-900/20 px-4 py-2 rounded-xl border border-emerald-100 dark:border-emerald-800">
                <i class="fas fa-check-double"></i>
                Assignment Confirmed
            </div>
        @elseif($job['status'] === 'assigned')
            {{-- State 2: Assigned but not yet confirmed --}}
            <button wire:click="confirmAttendance('{{ $job['uuid'] }}')" 
                wire:loading.attr="disabled"
                class="w-full sm:w-auto bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 px-8 py-2.5 rounded-xl text-xs font-bold hover:scale-105 transition shadow-lg flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="confirmAttendance('{{ $job['uuid'] }}')">
                    Confirm Attendance
                </span>
                <span wire:loading wire:target="confirmAttendance('{{ $job['uuid'] }}')">
                    Processing...
                </span>
            </button>
        @elseif($job['status'] === 'active')
            {{-- State 3: Duty is currently in progress --}}
            <span class="text-xs font-bold text-green-600 flex items-center gap-1">
                <i class="fas fa-satellite-dish animate-pulse"></i> 
                On-Site / Active
            </span>
        @endif
    </div>
</div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-zinc-50 dark:bg-zinc-800/20 rounded-3xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                <i class="fas fa-calendar-times text-4xl text-zinc-200 mb-4"></i>
                <p class="text-zinc-500 font-medium">No duties assigned yet.</p>
            </div>
        @endforelse
    </div>
</div>