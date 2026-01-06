<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">My Service Requests</h2>
            <p class="text-sm text-zinc-500">Track your active deployments and pending approvals.</p>
        </div>
        <div class="flex gap-3">
            <input wire:model.live.debounce.300ms="search" placeholder="Search missions..." class="border-none bg-white dark:bg-zinc-800 rounded-xl px-4 py-2 text-sm shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700">
            <a href="{{ route('client.request-service') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 transition">
                + New Request
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-3xl border dark:border-zinc-800 overflow-hidden shadow-sm">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50/50 dark:bg-zinc-800/50 text-zinc-500 font-bold border-b dark:border-zinc-800">
                <tr>
                    <th class="p-5">Mission Name</th>
                    <th class="p-5">Status</th>
                    <th class="p-5">Duration</th>
                    <th class="p-5">Assigned Team</th>
                    <th class="p-5 text-right">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-zinc-800">
                @forelse($requests as $req)
                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition">
                    <td class="p-5">
                        <div class="font-bold text-zinc-900 dark:text-white">{{ $req['title'] }}</div>
                        <div class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest mt-1">{{ $req['category'] }}</div>
                    </td>
                    <td class="p-5">
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-tight
                            {{ $req['status'] === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : 
                               ($req['status'] === 'assigned' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-green-50 text-green-700 border border-green-100') }}">
                            {{ $req['status'] }}
                        </span>
                    </td>
                    <td class="p-5">
                        <div class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $req['start_date'] }}</div>
                        <div class="text-zinc-400 text-xs">to {{ $req['end_date'] }}</div>
                    </td>
                    <td class="p-5">
                        @if(!empty($req['assigned_personnel']))
                            <div class="flex -space-x-3 overflow-hidden">
                                @foreach($req['assigned_personnel'] as $person)
                                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-900 object-cover" 
                                         src="{{ $person['photo'] }}" 
                                         alt="{{ $person['first_name'] }}"
                                         title="{{ $person['first_name'] }}">
                                @endforeach
                            </div>
                        @else
                            <span class="text-zinc-400 italic text-xs">Awaiting Admin...</span>
                        @endif
                    </td>
                    <td class="p-5 text-right">
                        <button class="text-zinc-400 hover:text-indigo-600 transition">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-shield-alt text-zinc-300 text-2xl"></i>
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white">No requests found</h3>
                            <p class="text-zinc-500 text-sm">You haven't made any security requests yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>