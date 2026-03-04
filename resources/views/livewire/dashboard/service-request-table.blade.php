<div class="p-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-zinc-900 dark:text-white uppercase tracking-tight">Mission Assignments</h2>
            <p class="text-zinc-500 text-sm font-medium">Review client requests and deploy personnel.</p>
        </div>
        <div class="flex items-center gap-3">
            <input wire:model.live.debounce.300ms="search" placeholder="Search mission or client..." 
                class="bg-white dark:bg-zinc-900 border-none rounded-xl px-4 py-2 text-sm ring-1 ring-zinc-200 dark:ring-zinc-800 focus:ring-2 focus:ring-indigo-600 transition outline-none">
        </div>

    </div>

    {{-- Main Table --}}
 <div class="bg-white dark:bg-zinc-900 rounded-[2rem] border dark:border-zinc-800 overflow-hidden shadow-sm uppercase text-xs">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
        <thead class="bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-400 font-bold border-b dark:border-zinc-800 text-[10px] tracking-widest uppercase">
            <tr>
                <th class="p-5">Client & Mission</th>
                <th class="p-5">Type</th>
                <th class="p-5">Timeline</th>
                <th class="p-5">Personnel</th>
                <th class="p-5 text-center">Status</th>
                <th class="p-5 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y dark:divide-zinc-800 font-medium">
            @forelse($requests as $req)
            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition" wire:key="row-{{ $req['uuid'] }}">
                <td class="p-5 uppercase">
                    <div class="font-black text-zinc-900 dark:text-white">{{ $req['title'] }}</div>
                    <div class="text-[10px] text-zinc-500">{{ $req['client']['company_name'] ?? 'Private Client' }}</div>
                </td>
                <td class="p-5">
                    <span class="px-2 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-[10px] font-black uppercase">
                        {{ $req['category'] }}
                    </span>
                </td>
                <td class="p-5">
                    <div class="text-zinc-700 dark:text-zinc-300 font-bold">{{ \Carbon\Carbon::parse($req['start_date'])->format('d M, Y') }}</div>
                    <div class="text-[10px] text-zinc-400 font-bold">Needs: {{ $req['required_staff_count'] ?? '0' }} Guards</div>
                </td>

                <td class="p-5">
                    <div class="flex -space-x-2">
                        @foreach($req['assigned_personnel'] ?? [] as $guard)
                            <div class="relative inline-block">
                                <img src="{{ $guard['photo'] }}" title="{{ $guard['full_name'] }}"
                                    class="w-8 h-8 rounded-full border-2 border-white dark:border-zinc-900 shadow-sm object-cover bg-zinc-200">
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 border-2 border-white dark:border-zinc-900 rounded-full 
                                    {{ isset($guard['confirmed_at']) && $guard['confirmed_at'] ? 'bg-emerald-500' : 'bg-amber-500' }}">
                                </span>
                            </div>
                        @endforeach
                    </div>
                </td>

                <td class="p-5 text-center">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                        {{ $req['status'] === 'pending' ? 'text-amber-600 bg-amber-50' : '' }}
                        {{ $req['status'] === 'approved' ? 'text-blue-600 bg-blue-50' : '' }}
                        {{ $req['status'] === 'assigned' ? 'text-indigo-600 bg-indigo-50' : '' }}
                        {{ $req['status'] === 'active' ? 'text-emerald-600 bg-emerald-50' : '' }}
                        {{ $req['status'] === 'completed' ? 'text-zinc-500 bg-zinc-100' : '' }}
                        {{ $req['status'] === 'rejected' ? 'text-red-500 bg-red-50' : '' }}
                        {{ $req['status'] === 'cancelled' ? 'text-red-600 bg-red-50' : '' }}">
                        {{ $req['status'] }}
                    </span>
                </td>

     <td class="p-5 text-right">
    {{-- Main Dropdown Wrapper --}}
    <div x-data="{ open: false }" class="relative inline-block text-left">
        
        {{-- 1. This wrapper keeps the Red Dot attached to the Button --}}
        <div class="relative inline-block">
            <button @click="open = !open" @click.away="open = false" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-xl text-[10px] font-black hover:bg-zinc-200 transition uppercase">
                Manage <i class="fas fa-chevron-down text-[8px]"></i>
            </button>

            {{-- 2. The Red Dot (Only shows if there are unread messages) --}}
            @if(isset($req['unread_count']) && $req['unread_count'] > 0)
                <span class="absolute -top-1 -right-1 flex h-3 w-3 z-10">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600 border border-white dark:border-zinc-900"></span>
                </span>
            @endif
        </div>

        {{-- 3. The Dropdown Menu --}}
        <div x-show="open" x-cloak x-transition 
            class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-2xl bg-white dark:bg-zinc-900 shadow-xl ring-1 ring-black/5 border dark:border-zinc-800 overflow-hidden text-left font-bold">
            
            <div class="py-1 uppercase text-[10px]">
                {{-- Your Menu Items (Open Chat, Deploy, etc.) --}}
                @if(in_array($req['status'], ['completed', 'cancelled', 'rejected']))
                    <div class="px-4 py-2 text-[9px] text-zinc-400 font-black tracking-widest border-b dark:border-zinc-800">Grace Period</div>
                    <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'assigned')" @click="open = false" 
                        class="flex w-full items-center px-4 py-3 text-indigo-600 hover:bg-indigo-50 font-black">
                        <i class="fas fa-undo mr-3"></i> Revert to Assigned
                    </button>
                @endif

                <button wire:click="openChat('{{ $req['uuid'] }}')" @click="open = false" 
                    class="flex w-full items-center px-4 py-3 text-red-600 hover:bg-red-50 font-black">
                    <i class="fas fa-comments mr-3"></i> Open Mission Chat
                </button>

                 @if(in_array($req['status'], ['approved', 'assigned']))
                    <button wire:click="openAssignModal('{{ $req['uuid'] }}')" @click="open = false" 
                        class="flex w-full items-center px-4 py-3 text-indigo-600 hover:bg-indigo-50 font-black">
                        <i class="fas fa-users mr-3"></i> Deploy Personnel
                    </button>
                    @endif

                    @if($req['status'] === 'assigned')
                    <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'active')" @click="open = false" 
                        class="flex w-full items-center px-4 py-3 text-blue-600 hover:bg-blue-50">
                        <i class="fas fa-play mr-3"></i> Start Mission
                    </button>
                    @endif

                    @if(in_array($req['status'], ['active', 'assigned']))
                    <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'completed')" 
                        wire:confirm="Confirm Mission Completion?" @click="open = false" 
                        class="flex w-full items-center px-4 py-3 text-zinc-900 dark:text-white hover:bg-zinc-50 border-t dark:border-zinc-800">
                        <i class="fas fa-flag-checkered mr-3"></i> Finish Mission
                    </button>
                    @endif

                    {{-- CANCELLATION (ONLY FOR NON-FINAL STATES) --}}
                    @if(!in_array($req['status'], ['completed', 'cancelled', 'rejected']))
                    <div class="border-t dark:border-zinc-800 my-1"></div>
                    <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'cancelled')" 
                        wire:confirm="Are you sure? Mission will be stopped." @click="open = false" 
                        class="flex w-full items-center px-4 py-3 text-red-600 hover:bg-red-50 font-black">
                        <i class="fas fa-ban mr-3"></i> Cancel Mission
                    </button>
                    @endif
            </div>
        </div>
    </div>
</td>
            </tr>
            @empty
            <tr><td colspan="6" class="p-10 text-center text-zinc-400 font-bold uppercase tracking-widest text-[10px]">No mission requests found.</td></tr>
            @endforelse
        </tbody>
    </table>
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
                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white uppercase tracking-tight">Deploy Personnel</h3>
                        <p class="text-zinc-500 text-sm font-medium">Mission: <span class="text-indigo-600">{{ $selectedRequest['title'] }}</span></p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 transition"><i class="fas fa-times"></i></button>
                </div>

                {{-- Status tracking for Assigned missions --}}
                @if($selectedRequest['status'] === 'assigned')
                    <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border dark:border-zinc-800">
                        <h4 class="text-[10px] font-black uppercase text-zinc-400 mb-3 tracking-widest">Team Confirmation</h4>
                        <div class="space-y-2">
                            @foreach($selectedRequest['assigned_personnel'] ?? [] as $guard)
                                <div class="flex items-center justify-between text-[10px] font-bold">
                                    <div class="flex items-center gap-2 uppercase">
                                        <img src="{{ $guard['photo'] }}" class="w-6 h-6 rounded-full bg-zinc-200 object-cover">
                                        <span class="text-zinc-700 dark:text-zinc-300">{{ $guard['full_name'] }}</span>
                                    </div>
                                    @if(isset($guard['confirmed_at']) && $guard['confirmed_at'])
                                        <span class="text-emerald-600 uppercase flex items-center gap-1"><i class="fas fa-check-circle"></i> Confirmed</span>
                                    @else
                                        <span class="text-amber-500 uppercase flex items-center gap-1 italic"><i class="fas fa-clock"></i> Pending...</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="space-y-6">
                    {{-- Guard Selection --}}
                   <div class="space-y-4">

    {{-- SEARCH SECTION --}}
    <div>

        <div class="flex items-center justify-between mb-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-zinc-400">
                Search Guards
            </label>

            @if($employeeSearch)
                <button 
                    wire:click="$set('employeeSearch', '')"
                    class="text-[10px] font-bold text-indigo-600 hover:underline"
                >
                    Clear
                </button>
            @endif
        </div>

        <div class="relative">

            {{-- Search Icon --}}
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- Input --}}
            <input 
                type="text"
                wire:model.live.debounce.400ms="employeeSearch"
                placeholder="Search by name, email, designation..."
                class="w-full pl-10 pr-10 py-2.5 rounded-2xl 
                       bg-white/70 dark:bg-zinc-900/70 
                       backdrop-blur border border-zinc-200 
                       dark:border-zinc-800 
                       text-sm font-medium
                       focus:ring-2 focus:ring-indigo-500/40 
                       focus:border-indigo-500
                       transition-all duration-200 outline-none"
            />

            {{-- Loading Spinner --}}
            <div wire:loading wire:target="employeeSearch"
                 class="absolute inset-y-0 right-3 flex items-center">
                <svg class="animate-spin h-4 w-4 text-indigo-500" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>

        </div>
    </div>


    {{-- GUARD SELECTION --}}
    <div>

       <div class="flex justify-between mb-2">
            <label class="block text-[10px] font-black uppercase text-zinc-400 tracking-widest">
                Select Guards
            </label>
            <span class="text-[10px] font-bold {{ count($selectedEmployees) > $selectedRequest['required_staff_count'] ? 'text-red-600' : 'text-zinc-400' }}">
                Selected: {{ count($selectedEmployees) }} / {{ $selectedRequest['required_staff_count'] }}
            </span>
        </div>
       
        <div class="grid grid-cols-2 gap-3 max-h-60 overflow-y-auto pr-2">
        @error('selectedEmployees')
                    <p class="mt-2 text-xs text-red-600 font-bold">{{ $message }}</p>
                @enderror
            @forelse($availableEmployees as $emp)

                @php
                    $isSelected = in_array((string)$emp['id'], array_map('strval', $selectedEmployees));
                @endphp

                <label wire:key="emp-{{ $emp['id'] }}"
                    class="relative flex items-center gap-3 p-3 rounded-2xl border 
                           dark:border-zinc-800 cursor-pointer 
                           hover:bg-zinc-50 dark:hover:bg-zinc-800/50 
                           transition-all duration-200
                           {{ $isSelected ? 'border-indigo-600 ring-2 ring-indigo-600 bg-indigo-50/30' : 'border-zinc-200 dark:border-zinc-800' }}">

                    <input type="checkbox"
                           wire:model.live="selectedEmployees"
                           value="{{ $emp['id'] }}"
                           class="hidden">

                    <img src="{{ $emp['photo'] }}"
                         class="w-10 h-10 rounded-full object-cover bg-zinc-200">

                    <div class="flex-1 min-w-0 uppercase">
                        <p class="text-xs font-black truncate text-zinc-900 dark:text-white">
                            {{ $emp['first_name'] }} {{ $emp['last_name'] }}
                        </p>
                        <p class="text-[9px] text-zinc-500 font-bold">
                            {{ $emp['designation'] ?? 'Guard' }}
                        </p>
                    </div>

                    @if($isSelected)
                        <i class="fas fa-check-circle text-indigo-600 text-sm"></i>
                    @endif

                </label>

            @empty

                <div class="col-span-2 text-center py-6 text-xs font-bold text-zinc-400 uppercase tracking-wider">
                    No guards found
                </div>

            @endforelse

        </div>
    </div>

</div>

                    {{-- Instructions --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase text-zinc-400 mb-2 tracking-widest">Mission Instructions</label>
                        <textarea wire:model="adminRemarks" rows="3" placeholder="Briefing for the team..." 
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 text-xs font-bold focus:ring-2 focus:ring-indigo-600 outline-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 flex justify-between items-center border-t dark:border-zinc-800">
                <div>
                    @if(!in_array($selectedRequest['status'], ['completed', 'cancelled']))
                        <button wire:click="updateRequestStatus('{{ $selectedRequest['uuid'] }}', 'cancelled')" 
                            wire:confirm="Cancel this mission?" class="text-red-600 text-[10px] font-black uppercase hover:underline">
                            Cancel Mission
                        </button>
                    @endif
                </div>
                <div class="flex gap-3">
                    <button wire:click="$set('showModal', false)" class="px-6 py-2 text-xs font-black text-zinc-500 uppercase">Close</button>
                    <button wire:click="confirmAssignment" class="bg-indigo-600 text-white px-8 py-2 rounded-xl text-xs font-black uppercase shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 transition">
                        Confirm Deployment
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        </div>



        {{-- CHAT MODAL --}}
@if($showChatModal && $selectedRequest)
<div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
    {{-- Dark Backdrop --}}
    <div class="absolute inset-0 bg-zinc-900/60 backdrop-blur-sm" wire:click="$set('showChatModal', false)"></div>
    
    {{-- Modal Content --}}
    <div class="relative bg-white dark:bg-zinc-900 w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden animate-in slide-in-from-bottom-4 duration-300">
        
        <div class="p-6 border-b dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/50">
            <div>
                <h3 class="text-lg font-black text-zinc-900 dark:text-white uppercase">Mission Audit Log</h3>
                <p class="text-[10px] text-zinc-500 font-bold uppercase">ID: {{ $selectedRequest['uuid'] }}</p>
            </div>
            <button wire:click="$set('showChatModal', false)" class="text-zinc-400 hover:text-red-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

            <div class="p-4">
                @if($selectedRequest)
                    @livewire('chat.mission-chat', [
                        'missionId' => $selectedRequest['uuid']
                    ], key($selectedRequest['uuid']))
                @endif
            </div>

        <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 text-center">
            <button wire:click="$set('showChatModal', false)" class="text-[10px] font-black uppercase text-zinc-400 hover:text-zinc-600">
                Close Chat
            </button>
        </div>
    </div>
</div>
@endif

</div>