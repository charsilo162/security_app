<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h2 class="text-xl font-bold flex items-center gap-2">
            Employees <span class="text-sm bg-indigo-100 text-indigo-600 px-2 rounded-full">{{ $total }}</span>
        </h2>
        <div class="flex gap-3">
            <input wire:model.live.debounce.300ms="search" placeholder="Search..." class="border rounded-lg px-4 py-2 text-sm dark:bg-zinc-800">
            <button wire:click="openCreateModal" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition font-medium">
                + Add Employee
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border dark:border-zinc-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 font-semibold border-b dark:border-zinc-700">
                <tr>
                    <th class="p-4 text-left">Employee Name</th>
                    <th class="p-4 text-left">Designation</th>
                    <th class="p-4 text-left">Department</th>
                    <th class="p-4 text-left">Join Date</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $emp)
                <tr class="border-b dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                    {{-- <td class="p-4">
                        <div class="font-bold">{{ $emp['full_name'] }}</div>
                        <div class="text-xs text-zinc-400">{{ $emp['email'] }}</div>
                    </td> --}}
                    <td class="p-4">
                        <a href="{{ route('employees.show', $emp['uuid']) }}" class="group">
                            <div class="font-bold text-indigo-600 group-hover:underline">{{ $emp['full_name'] }}</div>
                            <div class="text-xs text-zinc-400">{{ $emp['email'] }}</div>
                        </a>
                    </td>
                    <td class="p-4">{{ $emp['designation'] }}</td>
                    <td class="p-4 text-zinc-500">{{ $emp['department'] }}</td>
                    <td class="p-4">{{ $emp['joining_date'] }}</td>
                   <td class="p-4 text-right flex justify-end gap-3">
                        <button wire:click="openEditModal('{{ $emp['uuid'] }}')" class="text-indigo-600 hover:underline font-medium">Edit</button>
                        
                        <button wire:click="$dispatch('open-delete-modal', { uuid: '{{ $emp['uuid'] }}' })" class="text-red-500 hover:underline font-medium">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="p-6 border-b dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900">
                <h3 class="text-xl font-bold">{{ $editId ? 'Update Employee Record' : 'Register New Employee' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-black text-2xl">×</button>
            </div>

<form wire:submit.prevent="save" class="p-8 space-y-8" enctype="multipart/form-data">
    <div>
        <h4 class="text-indigo-600 font-bold text-sm uppercase mb-4">Profile Image & Bio</h4>
        <div class="flex flex-col md:flex-row gap-6 items-start">
            <div class="flex-shrink-0">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full border-2 border-dashed border-zinc-300 dark:border-zinc-700 flex items-center justify-center overflow-hidden bg-zinc-50 dark:bg-zinc-800">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif(isset($currentPhotoUrl))
                            <img src="{{ $currentPhotoUrl }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-camera text-zinc-400 text-2xl"></i>
                        @endif
                    </div>
                    <label class="mt-2 block cursor-pointer">
                        <span class="text-xs text-indigo-600 font-semibold hover:underline">Change Photo</span>
                        <input type="file" wire:model="photo" class="hidden" accept="image/*">
                    </label>
                </div>
                @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex-grow w-full">
                <label class="block text-xs font-semibold mb-1">Short Bio</label>
                <textarea wire:model="bio" rows="4" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700 focus:ring-2 focus:ring-indigo-500 outline-none"
                    placeholder="Brief professional background..."></textarea>
                @error('bio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="pt-6 border-t dark:border-zinc-800">
        <h4 class="text-indigo-600 font-bold text-sm uppercase mb-4">Personal & Contact Info</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-semibold mb-1">First Name</label>
                <input wire:model="first_name" type="text" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('first_name') border-red-500 @else border-zinc-300 @enderror">
                @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Last Name</label>
                <input wire:model="last_name" type="text" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('last_name') border-red-500 @else border-zinc-300 @enderror">
                @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Email</label>
                <input wire:model="email" type="email" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('email') border-red-500 @else border-zinc-300 @enderror">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Gender</label>
                <select wire:model="gender" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Date of Birth</label>
                <input wire:model="date_of_birth" type="date" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Phone</label>
                <input wire:model="phone" type="tel" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('phone') border-red-500 @else border-zinc-300 @enderror">
                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold mb-1">Address</label>
                <input wire:model="address" type="text" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('address') border-red-500 @else border-zinc-300 @enderror">
                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">
                    {{ $editId ? 'New Password (Optional)' : 'Default Password' }}
                </label>
                <input wire:model="password" type="password" placeholder="••••••••"
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="pt-6 border-t dark:border-zinc-800">
        <h4 class="text-indigo-600 font-bold text-sm uppercase mb-4">Job & Department</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-semibold mb-1">Designation</label>
                <input wire:model="designation" type="text" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('designation') border-red-500 @else border-zinc-300 @enderror">
                @error('designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Department</label>
                <input wire:model="department" type="text" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('department') border-red-500 @else border-zinc-300 @enderror">
                @error('department') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Joining Date</label>
                <input wire:model="joining_date" type="date" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('joining_date') border-red-500 @else border-zinc-300 @enderror">
                @error('joining_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="pt-6 border-t dark:border-zinc-800">
        <h4 class="text-indigo-600 font-bold text-sm uppercase mb-4">Banking Details</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <input wire:model="bank_name" placeholder="Bank Name" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('bank_name') border-red-500 @enderror">
                @error('bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <input wire:model="account_number" type="number" placeholder="Account Number" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('account_number') border-red-500 @enderror">
                @error('account_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <input wire:model="account_holder_name" placeholder="Account Holder Name" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('account_holder_name') border-red-500 @enderror">
                @error('account_holder_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <input wire:model="branch_name" placeholder="Branch Name" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('branch_name') border-red-500 @enderror">
                @error('branch_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <input wire:model="routing_number" placeholder="Routing Number" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('routing_number') border-red-500 @enderror">
                @error('routing_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <input wire:model="swift_code" placeholder="Swift Code" 
                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('swift_code') border-red-500 @enderror">
                @error('swift_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 pt-6 border-t dark:border-zinc-800">
        <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2 border rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700">Cancel</button>
        <button type="submit" wire:loading.attr="disabled" class="px-8 py-2 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700 transition disabled:opacity-50">
            <span wire:loading.remove>{{ $editId ? 'Save Changes' : 'Register Employee' }}</span>
            <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i> Processing...</span>
        </button>
    </div>
</form>
        </div>
    </div>
    @endif
</div>