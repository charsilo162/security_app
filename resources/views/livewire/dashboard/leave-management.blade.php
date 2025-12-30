<div class="space-y-6 p-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Total Requests', 'val' => 'total', 'icon' => 'fa-calendar', 'color' => 'indigo'],
                ['label' => 'Approved', 'val' => 'approved', 'icon' => 'fa-check-circle', 'color' => 'green'],
                ['label' => 'Pending', 'val' => 'pending', 'icon' => 'fa-clock', 'color' => 'orange'],
                ['label' => 'Rejected', 'val' => 'rejected', 'icon' => 'fa-times-circle', 'color' => 'red'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-white dark:bg-zinc-900 p-5 rounded-xl border dark:border-zinc-800 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 rounded-lg">
                        <i class="fas {{ $card['icon'] }} text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500 uppercase font-bold">{{ $card['label'] }}</p>
                        <h2 class="text-2xl font-black">{{ $stats[$card['val']] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="p-4 border-b dark:border-zinc-800 flex justify-between items-center">
            <h3 class="font-bold">Leave Requests</h3>
            <select wire:model.live="filterStatus" class="text-sm border rounded-lg p-2 dark:bg-zinc-800">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500">
                <tr>
                    <th class="p-4">Employee</th>
                    <th class="p-4">Leave Type</th>
                    <th class="p-4">Duration</th>
                    <th class="p-4 text-center">Days</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr class="border-b dark:border-zinc-800 hover:bg-zinc-50 transition">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $req['employee']['avatar'] ?? 'https://ui-avatars.com/api/?name='.$req['employee']['full_name'] }}" class="w-8 h-8 rounded-full">
                            <span class="font-bold">{{ $req['employee']['full_name'] }}</span>
                        </div>
                    </td>
                    <td class="p-4">{{ $req['leave_type'] }}</td>
                    <td class="p-4 text-zinc-500">{{ $req['start_date'] }} - {{ $req['end_date'] }}</td>
                    <td class="p-4 text-center font-medium">{{ $req['days'] }}</td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                            {{ $req['status'] === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $req['status'] === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $req['status'] === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $req['status'] }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        @if($req['status'] === 'pending')
                            <button wire:click="reviewRequest('{{ $req['uuid'] }}')" class="bg-indigo-600 text-white px-3 py-1 rounded-md text-xs hover:bg-indigo-700">
                                Review
                            </button>
                        @else
                            <button class="text-zinc-400 cursor-not-allowed"><i class="fas fa-check-double"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($selectedRequest)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-md p-6 shadow-2xl">
            <h3 class="text-xl font-bold mb-2">Review Leave Request</h3>
            <p class="text-sm text-zinc-500 mb-4">Submitted by <span class="text-indigo-600 font-bold">{{ $selectedRequest['employee']['full_name'] }}</span></p>
            
            <div class="bg-zinc-50 dark:bg-zinc-800 p-4 rounded-xl mb-4 text-sm italic">
                "{{ $selectedRequest['reason'] }}"
            </div>

            <label class="block text-xs font-bold mb-2 text-zinc-400 uppercase">Manager Remarks (Optional)</label>
            <textarea wire:model="adminRemarks" class="w-full border rounded-xl p-3 dark:bg-zinc-800 mb-6" placeholder="Reason for approval or rejection..."></textarea>

            <div class="flex gap-3">
                <button wire:click="updateStatus('rejected')" class="flex-1 py-3 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-100 transition">Reject</button>
                <button wire:click="updateStatus('approved')" class="flex-1 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Approve</button>
            </div>
            <button wire:click="$set('selectedRequest', null)" class="w-full mt-4 text-sm text-zinc-400 hover:underline">Cancel</button>
        </div>
    </div>
    @endif
</div>