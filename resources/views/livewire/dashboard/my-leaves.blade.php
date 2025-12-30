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
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                            {{ $req['status'] === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $req['status'] === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $req['status'] === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $req['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($showApplyModal)
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-3xl w-full max-w-lg p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-black">Apply New Leave</h3>
                <button wire:click="$set('showApplyModal', false)" class="text-zinc-400"><i class="fas fa-times"></i></button>
            </div>

            <form wire:submit.prevent="submitRequest" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">Leave Type</label>
                    <select wire:model="leave_type_id" class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3">
                        <option value="">Select Type</option>
                        @foreach($balances as $b)
                            <option value="{{ $b['leave_type_id'] }}">{{ $b['leave_type_name'] }} ({{ $b['remaining_days'] }} left)</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">Start Date</label>
                        <input type="date" wire:model="start_date" class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">End Date</label>
                        <input type="date" wire:model="end_date" class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-400 uppercase mb-2">Reason for Leave</label>
                    <textarea wire:model="reason" rows="3" class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl p-3" placeholder="Briefly describe your reason..."></textarea>
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 dark:shadow-none">
                    Submit Request
                </button>
            </form>
        </div>
    </div>
    @endif
</div>