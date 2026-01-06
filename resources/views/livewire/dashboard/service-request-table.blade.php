<div class="p-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-zinc-900 dark:text-white uppercase tracking-tight">Mission Assignments</h2>
            <p class="text-zinc-500 text-sm font-medium">Review client requests and deploy personnel.</p>
        </div>
        <div class="flex items-center gap-3">
            <input wire:model.live.debounce.300ms="search" placeholder="Search mission or client..." 
                class="bg-white dark:bg-zinc-900 border-none rounded-xl px-4 py-2 text-sm ring-1 ring-zinc-200 dark:ring-zinc-800 focus:ring-2 focus:ring-indigo-600 transition">
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-white dark:bg-zinc-900 rounded-[2rem] border dark:border-zinc-800 overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-500 font-bold border-b dark:border-zinc-800 uppercase text-[10px] tracking-widest">
                <tr>
                    <th class="p-5">Client & Mission</th>
                    <th class="p-5">Type</th>
                    <th class="p-5">Timeline</th>
                    <th class="p-5">Personnel</th>
                    <th class="p-5">Status</th>
                    <th class="p-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-zinc-800">
                @forelse($requests as $req)
                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition">
                    <td class="p-5">
                        <div class="font-bold text-zinc-900 dark:text-white">{{ $req['title'] }}</div>
                        <div class="text-xs text-zinc-500">{{ $req['client']['company_name'] ?? 'Private Client' }}</div>
                    </td>
                    <td class="p-5">
                        <span class="px-2 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 font-bold text-[10px] uppercase">
                            {{ $req['category'] }}
                        </span>
                    </td>
                    <td class="p-5">
                        <div class="text-zinc-700 dark:text-zinc-300">{{ $req['start_date'] }}</div>
                        <div class="text-[10px] text-zinc-400">Total: {{ $req['required_staff_count'] ?? '0' }} Guards</div>
                    </td>
                   {{-- Update the Personnel TD in your Main Table --}}
                    <td class="p-5">
                        <div class="flex -space-x-2">
                            @foreach($req['assigned_personnel'] ?? [] as $guard)
                                <div class="relative inline-block">
                                    <img src="{{ $guard['photo'] }}" 
                                        title="{{ $guard['full_name'] }}"
                                        class="w-8 h-8 rounded-full border-2 border-white dark:border-zinc-900 shadow-sm object-cover">
                                    
                                    {{-- Confirmation Dot Indicator --}}
                                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 border-2 border-white dark:border-zinc-900 rounded-full 
                                        {{ isset($guard['confirmed_at']) && $guard['confirmed_at'] ? 'bg-emerald-500' : 'bg-amber-500' }}">
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-1 text-[9px] font-bold text-zinc-400 uppercase tracking-tighter">
                            {{-- Show a summary like: 2/3 Confirmed --}}
                            @php 
                                $confirmedCount = collect($req['assigned_personnel'])->whereNotNull('confirmed_at')->count();
                                $totalCount = count($req['assigned_personnel'] ?? []);
                            @endphp
                            @if($totalCount > 0)
                                <span class="{{ $confirmedCount === $totalCount ? 'text-emerald-600' : '' }}">
                                    {{ $confirmedCount }}/{{ $totalCount }} Confirmed
                                </span>
                            @endif
                        </div>
                    </td>
                   <td class="p-5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                            {{ $req['status'] === 'pending' ? 'text-amber-600 bg-amber-50' : '' }}
                            {{ $req['status'] === 'approved' ? 'text-blue-600 bg-blue-50' : '' }}
                            {{ $req['status'] === 'assigned' ? 'text-indigo-600 bg-indigo-50' : '' }}
                            {{ $req['status'] === 'active' ? 'text-emerald-600 bg-emerald-50' : '' }}
                            {{ $req['status'] === 'completed' ? 'text-zinc-600 bg-zinc-100' : '' }}">
                            {{ $req['status'] }}
                        </span>
                    </td>
                   <td class="p-5 text-right">
                        @if($req['status'] === 'pending')
                            <button wire:click="approveRequest('{{ $req['uuid'] }}')" 
                                class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-700 transition">
                                Approve
                            </button>
                            
                        @elseif($req['status'] === 'approved')
                            <button wire:click="openAssignModal('{{ $req['uuid'] }}')" 
                                class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition">
                                Assign Staff
                            </button>

                        @elseif($req['status'] === 'assigned')
                            {{-- Now it works! Allows changing guards --}}
                            <button wire:click="openAssignModal('{{ $req['uuid'] }}')" 
                                class="text-indigo-600 bg-indigo-50 px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-100 transition">
                                <i class="fas fa-user-plus mr-1"></i> Edit Team
                            </button>

                        @elseif($req['status'] === 'active')
                            {{-- Function to finish the mission --}}
                            <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'completed')" 
                                class="text-zinc-600 bg-zinc-100 px-4 py-2 rounded-xl text-xs font-bold hover:bg-zinc-200 transition">
                                <i class="fas fa-check-double mr-1"></i> End Mission
                            </button>
                        @endif
                </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-10 text-center text-zinc-400">No mission requests found.</td></tr>
                @endforelse
            </tbody>
        </table>

{{-- Pagination Controls --}}
<div class="p-6 border-t dark:border-zinc-800 flex items-center justify-between bg-zinc-50/50 dark:bg-zinc-900">
    <p class="text-xs text-zinc-500 font-medium">
        Showing <span class="text-zinc-900 dark:text-white">{{ count($requests) }}</span> of {{ $total }} results
    </p>

    <div class="flex gap-2">
        @if($this->getPage() > 1)
            <button wire:click="previousPage" class="px-4 py-2 text-xs font-bold bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded-xl hover:bg-zinc-50">
                Previous
            </button>
        @endif

        @if(count($requests) >= $perPage)
            <button wire:click="nextPage" class="px-4 py-2 text-xs font-bold bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded-xl hover:bg-zinc-50">
                Next
            </button>
        @endif
    </div>
</div>



    </div>

    {{-- ASSIGNMENT MODAL --}}
    @if($showModal && $selectedRequest)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-zinc-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
        <div class="relative bg-white dark:bg-zinc-900 w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200">
            
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white">Deploy Personnel</h3>
                        <p class="text-zinc-500 text-sm">Assign guards for: <span class="text-indigo-600 font-bold">{{ $selectedRequest['title'] }}</span></p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600"><i class="fas fa-times"></i></button>
                </div>

                {{-- Place this inside the Modal, above the Guard Selection List --}}
@if($selectedRequest['status'] === 'assigned')
    <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-100 dark:border-zinc-800">
        <h4 class="text-[10px] font-bold uppercase text-zinc-400 mb-3 tracking-widest">Deployment Status</h4>
        <div class="space-y-2">
            @foreach($selectedRequest['assigned_personnel'] ?? [] as $guard)
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <img src="{{ $guard['photo'] }}" class="w-6 h-6 rounded-full">
                        <span class="font-bold text-zinc-700 dark:text-zinc-300">{{ $guard['full_name'] }}</span>
                    </div>
                    
                    @if(isset($guard['confirmed_at']) && $guard['confirmed_at'])
                        <span class="text-emerald-600 font-bold flex items-center gap-1">
                            <i class="fas fa-check-circle text-[10px]"></i> 
                            Confirmed ({{ \Carbon\Carbon::parse($guard['confirmed_at'])->format('H:i') }})
                        </span>
                    @else
                        <span class="text-amber-500 font-bold flex items-center gap-1 italic">
                            <i class="fas fa-clock text-[10px]"></i> Awaiting...
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

                <div class="space-y-6">
                    {{-- Multi-Select Guard List --}}
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-3 tracking-widest">Select Guards (Available)</label>
                        <div class="grid grid-cols-2 gap-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
    @foreach($availableEmployees as $emp)
        {{-- 1. Use wire:key for stable DOM tracking --}}
        <label wire:key="emp-{{ $emp['id'] }}" 
            class="relative flex items-center gap-3 p-3 rounded-2xl border dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-all
            {{ in_array((string)$emp['id'], array_map('strval', $selectedEmployees)) ? 'border-indigo-600 ring-2 ring-indigo-600 bg-indigo-50/30' : '' }}">
            
            {{-- 2. Use .live to force the UI to update the border immediately --}}
            <input type="checkbox" 
                wire:model.live="selectedEmployees" 
                value="{{ $emp['id'] }}" 
                class="hidden">

            <img src="{{ $emp['photo'] }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
            
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold truncate text-zinc-900 dark:text-white">
                    {{ $emp['first_name'] }} {{ $emp['last_name'] }}
                </p>
                <p class="text-[10px] text-zinc-500 font-medium">
                    {{ $emp['designation'] ?? 'Security Guard' }}
                </p>
            </div>

            {{-- Checkmark icon --}}
            @if(in_array((string)$emp['id'], array_map('strval', $selectedEmployees)))
                <i class="fas fa-check-circle text-indigo-600 animate-in zoom-in"></i>
            @endif
        </label>
    @endforeach
</div>
                    </div>

                    {{-- Remarks --}}
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-widest">Admin Instructions (Optional)</label>
                        <textarea wire:model="adminRemarks" rows="3" placeholder="Special briefing or notes for the team..." 
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-indigo-600"></textarea>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 flex justify-end gap-3">
                <button wire:click="$set('showModal', false)" class="px-6 py-2 text-sm font-bold text-zinc-500">Cancel</button>
                <button wire:click="confirmAssignment" class="bg-indigo-600 text-white px-8 py-2 rounded-xl text-sm font-bold shadow-lg hover:bg-indigo-700 transition">
                    Confirm Deployment
                </button>
            </div>
        </div>
    </div>
    @endif
</div>