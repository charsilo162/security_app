<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">My Leave Overview</h2>
        <button wire:click="$set('showApplyModal', true)" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i> Apply for Leave
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($balances as $balance)
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border dark:border-zinc-800 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-calendar-check text-5xl"></i>
            </div>
            <p class="text-zinc-500 text-xs font-bold uppercase tracking-wider">{{ $balance['leave_type_name'] }}</p>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-black">{{ $balance['remaining_days'] }}</span>
                <span class="text-zinc-400 text-sm">/ {{ $balance['entitled_days'] }} Days left</span>
            </div>
            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2 mt-4 rounded-full overflow-hidden">
                <div class="bg-indigo-600 h-full" style="width: {{ ($balance['remaining_days'] / $balance['entitled_days']) * 100 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-2xl border dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="p-4 border-b dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/50">
            <h3 class="font-bold">My Request History</h3>
        </div>
        <table class="w-full text-left text-sm">
            <thead class="text-zinc-400 uppercase text-[10px] font-black">
                <tr>
                    <th class="p-4">Type</th>
                    <th class="p-4">Dates</th>
                    <th class="p-4">Total Days</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $req)
                <tr class="border-b dark:border-zinc-800 hover:bg-zinc-50 transition">
                    <td class="p-4 font-bold">{{ $req['leave_type'] }}</td>
                    <td class="p-4 text-zinc-500">{{ $req['start_date'] }} - {{ $req['end_date'] }}</td>
                    <td class="p-4 font-medium">{{ $req['days'] }} Days</td>
                   <td class="p-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                                {{ $req['status'] === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $req['status'] === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $req['status'] === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $req['status'] }}
                            </span>

                            @if($req['status'] === 'pending')
                                <button 
                                    wire:confirm="Are you sure you want to cancel this leave request?"
                                    wire:click="cancelRequest('{{ $req['uuid'] }}')" 
                                    class="ml-4 text-red-500 hover:text-red-700 transition"
                                    title="Cancel Request"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        @if($showApplyModal)
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" 
                wire:click.self="$set('showApplyModal', false)">
                
                <div class="bg-white dark:bg-zinc-900 rounded-3xl w-full max-w-lg p-8 shadow-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white">Apply New Leave</h3>
                        <button wire:click="$set('showApplyModal', false)" class="text-zinc-400 hover:text-zinc-600 transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="submitRequest" class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">Leave Type</label>
                            <select wire:model="leave_type_id" 
                                class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3 @error('leave_type_id') ring-2 ring-red-500 @enderror">
                                <option value="">Select Type</option>
                                @isset($leaveTypes)
                                    @foreach($leaveTypes as $type)
                                        @php
                                            $currentBalance = collect($balances)->firstWhere('leave_type_id', $type['id']);
                                            $remaining = $currentBalance['remaining_days'] ?? $type['default_days'];
                                        @endphp
                                        <option value="{{ $type['id'] }}">
                                            {{ $type['name'] }} ({{ $remaining }} days available)
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('leave_type_id') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">Start Date</label>
                                <input type="date" wire:model="start_date" 
                                    class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3 @error('start_date') ring-2 ring-red-500 @enderror">
                                @error('start_date') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">End Date</label>
                                <input type="date" wire:model="end_date" 
                                    class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3 @error('end_date') ring-2 ring-red-500 @enderror">
                                @error('end_date') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">Reason for Leave</label>
                            <textarea wire:model="reason" rows="3" 
                                class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3 @error('reason') ring-2 ring-red-500 @enderror" 
                                placeholder="Briefly describe your reason..."></textarea>
                            @error('reason') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="button" 
                                    wire:click="$set('showApplyModal', false)" 
                                    class="flex-1 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded-2xl font-bold hover:bg-zinc-200 dark:hover:bg-zinc-700 transition order-2 sm:order-1">
                                Cancel
                            </button>
                            
                            <button type="submit" 
                                    wire:loading.attr="disabled" 
                                    class="flex-[2] py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 dark:shadow-none flex items-center justify-center order-1 sm:order-2">
                                <span wire:loading.remove>Submit Request</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
</div>