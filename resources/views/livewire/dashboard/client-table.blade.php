<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h2 class="text-xl font-bold flex items-center gap-2">
            Corporate Clients <span class="text-sm bg-indigo-100 text-indigo-600 px-2 rounded-full">{{ $total }}</span>
        </h2>
        <div class="flex gap-3">
            <input wire:model.live.debounce.300ms="search" placeholder="Search Companies..." class="border rounded-lg px-4 py-2 text-sm dark:bg-zinc-800">
            <button wire:click="openCreateModal" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition font-medium">
                + Register Client
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border dark:border-zinc-700 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 font-semibold border-b dark:border-zinc-700">
                <tr>
                    <th class="p-4">Company Details</th>
                    <th class="p-4">Industry</th>
                    <th class="p-4">Representative</th>
                    <th class="p-4">Reg Number</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr class="border-b dark:border-zinc-800 hover:bg-zinc-50 transition">
                    <td class="p-4">
                        <div class="font-bold text-indigo-600">{{ $client['company_name'] }}</div>
                        <div class="text-xs text-zinc-400">{{ $client['address'] }}</div>
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 text-xs uppercase font-bold">
                            {{ $client['industry'] ?? 'General' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="font-medium">{{ $client['first_name'] }} {{ $client['last_name'] }}</div>
                        <div class="text-xs text-zinc-400">{{ $client['email'] }}</div>
                    </td>
                    <td class="p-4 text-zinc-500 font-mono">{{ $client['registration_number'] ?? 'N/A' }}</td>
                    <td class="p-4 text-right flex justify-end gap-3">
                        <button wire:click="openEditModal('{{ $client['uuid'] }}')" class="text-indigo-600 hover:underline">Edit</button>
                        <button 
                            wire:confirm="Are you sure you want to delete this client? All their requests will be lost."
                            wire:click="deleteClient('{{ $client['uuid'] }}')" 
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Client Modal --}}
    @if($showModal)
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="p-6 border-b dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
                <h3 class="text-xl font-bold">{{ $editId ? 'Update Client Profile' : 'Register New Corporate Client' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-black text-2xl">×</button>
            </div>

            <form wire:submit.prevent="save" class="p-8 space-y-8">
                {{-- Section 1: Business Details --}}
                <div>
                    <h4 class="text-indigo-600 font-bold text-sm uppercase mb-4">Business Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold mb-1">Company Full Name</label>
                            <input wire:model="company_name" type="text" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Industry Type</label>
                            <input wire:model="industry" type="text" placeholder="e.g. Banking, Retail" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                        </div>
                       
                         <div>
                            <label class="block text-xs font-semibold mb-1">Business Address</label>
                            <textarea wire:model="address" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Account Representative --}}
                <div class="pt-6 border-t dark:border-zinc-800">
                    <h4 class="text-indigo-600 font-bold text-sm uppercase mb-4">Contact Representative</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold mb-1">First Name</label>
                            <input wire:model="first_name" type="text" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Last Name</label>
                            <input wire:model="last_name" type="text" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Work Email</label>
                            <input wire:model="email" type="email" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Phone Number</label>
                            <input wire:model="phone" type="tel" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Account Password</label>
                            <input wire:model="password" type="password" placeholder="••••••••" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t dark:border-zinc-800">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2 border rounded-lg">Cancel</button>
                    <button type="submit" class="px-8 py-2 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700 transition">
                        {{ $editId ? 'Update Client' : 'Register Client' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>