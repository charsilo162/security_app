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
    <table class="w-full text-left">
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
                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <button @click="open = !open" @click.away="open = false" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-xl text-[10px] font-black hover:bg-zinc-200 transition uppercase">
                            Manage <i class="fas fa-chevron-down text-[8px]"></i>
                        </button>

                        <div x-show="open" x-cloak x-transition class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-2xl bg-white dark:bg-zinc-900 shadow-xl ring-1 ring-black/5 border dark:border-zinc-800 overflow-hidden text-left font-bold">
                            <div class="py-1 uppercase text-[10px]">
                                
                                {{-- RESTORE/UNDO ACTIONS (The Grace Period) --}}
                                @if(in_array($req['status'], ['completed', 'cancelled', 'rejected']))
                                    <div class="px-4 py-2 text-[9px] text-zinc-400 font-black tracking-widest border-b dark:border-zinc-800">Grace Period</div>
                                    <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'assigned')" @click="open = false" 
                                        class="flex w-full items-center px-4 py-3 text-indigo-600 hover:bg-indigo-50 font-black">
                                        <i class="fas fa-undo mr-3"></i> Revert to Assigned
                                    </button>
                                    @if($req['status'] === 'completed')
                                    <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'active')" @click="open = false" 
                                        class="flex w-full items-center px-4 py-3 text-blue-600 hover:bg-blue-50 font-black">
                                        <i class="fas fa-play mr-3"></i> Revert to Active
                                    </button>
                                    @endif
                                @endif

                                {{-- NORMAL FLOW ACTIONS --}}
                                @if($req['status'] === 'pending')
                                    <button wire:click="approveRequest('{{ $req['uuid'] }}')" @click="open = false" 
                                        class="flex w-full items-center px-4 py-3 text-emerald-600 hover:bg-emerald-50">
                                        <i class="fas fa-check-circle mr-3"></i> Approve
                                    </button>
                                    <button wire:click="updateRequestStatus('{{ $req['uuid'] }}', 'rejected')" @click="open = false" 
                                        class="flex w-full items-center px-4 py-3 text-red-400 hover:bg-red-50">
                                        <i class="fas fa-times-circle mr-3"></i> Reject
                                    </button>
                                @endif

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
                    <div>
                        <label class="block text-[10px] font-black uppercase text-zinc-400 mb-3 tracking-widest">Select Guards</label>
                        <div class="grid grid-cols-2 gap-3 max-h-60 overflow-y-auto pr-2">
                            @foreach($availableEmployees as $emp)
                                <label wire:key="emp-{{ $emp['id'] }}" 
                                    class="relative flex items-center gap-3 p-3 rounded-2xl border dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-all
                                    {{ in_array((string)$emp['id'], array_map('strval', $selectedEmployees)) ? 'border-indigo-600 ring-2 ring-indigo-600 bg-indigo-50/30' : '' }}">
                                    
                                    <input type="checkbox" wire:model.live="selectedEmployees" value="{{ $emp['id'] }}" class="hidden">
                                    <img src="{{ $emp['photo'] }}" class="w-10 h-10 rounded-full object-cover bg-zinc-200">
                                    <div class="flex-1 min-w-0 uppercase">
                                        <p class="text-xs font-black truncate text-zinc-900 dark:text-white">{{ $emp['first_name'] }} {{ $emp['last_name'] }}</p>
                                        <p class="text-[9px] text-zinc-500 font-bold">{{ $emp['designation'] ?? 'Guard' }}</p>
                                    </div>
                                    @if(in_array((string)$emp['id'], array_map('strval', $selectedEmployees)))
                                        <i class="fas fa-check-circle text-indigo-600"></i>
                                    @endif
                                </label>
                            @endforeach
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
</div>