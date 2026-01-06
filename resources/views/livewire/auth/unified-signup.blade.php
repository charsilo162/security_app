<div class="max-w-4xl mx-auto my-10 bg-zinc-900 border border-zinc-800 shadow-2xl rounded-2xl overflow-hidden">
    <div class="bg-zinc-800/50 p-8 text-center border-b border-zinc-800">
        <h2 class="text-3xl font-bold text-white">Secure Registration</h2>
        <p class="text-zinc-400 mt-2">Please fill in your details to create your secure profile.</p>
        
        <div class="flex p-1 bg-zinc-950 rounded-xl mt-6 max-w-xs mx-auto border border-zinc-800">
            <button wire:click="setRole('employee')" class="flex-1 py-2 text-sm font-medium rounded-lg transition-all {{ $role === 'employee' ? 'bg-red-600 text-white shadow-lg' : 'text-zinc-400 hover:text-white' }}">Employee</button>
            <button wire:click="setRole('client')" class="flex-1 py-2 text-sm font-medium rounded-lg transition-all {{ $role === 'client' ? 'bg-red-600 text-white shadow-lg' : 'text-zinc-400 hover:text-white' }}">Client</button>
        </div>
    </div>

    
    




    <form wire:submit.prevent="signup" class="p-8 space-y-8">
        
        <div class="space-y-6">
            <h3 class="text-red-500 font-bold uppercase tracking-wider text-xs">Step 1: Account Information</h3>
            
            <div class="flex flex-col items-center">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full bg-zinc-800 border-2 {{ $errors->has('photo') ? 'border-red-500' : 'border-dashed border-zinc-700' }} flex items-center justify-center overflow-hidden">
                        @if ($photo) <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-60H6" /></svg> @endif
                    </div>
                    <label class="absolute bottom-0 right-0 bg-red-600 p-2 rounded-full cursor-pointer hover:bg-red-700 transition">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                        <input type="file" wire:model="photo" class="hidden">
                    </label>
                </div>
                @error('photo') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-sm text-zinc-400 block">First Name</label>
                    <input type="text" wire:model="first_name" class="w-full bg-zinc-950 border {{ $errors->has('first_name') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white focus:ring-2 focus:ring-red-600 outline-none">
                    @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-sm text-zinc-400 block">Last Name</label>
                    <input type="text" wire:model="last_name" class="w-full bg-zinc-950 border {{ $errors->has('last_name') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white focus:ring-2 focus:ring-red-600 outline-none">
                    @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2 space-y-1">
                    <label class="text-sm text-zinc-400 block">Email Address</label>
                    <input type="email" wire:model="email" class="w-full bg-zinc-950 border {{ $errors->has('email') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white focus:ring-2 focus:ring-red-600 outline-none">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-sm text-zinc-400 block">Phone</label>
                    <input type="text" wire:model="phone" class="w-full bg-zinc-950 border {{ $errors->has('phone') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white focus:ring-2 focus:ring-red-600 outline-none">
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-400 block">Address</label>
                    <input type="text" wire:model="address" class="w-full bg-zinc-950 border {{ $errors->has('address') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white focus:ring-2 focus:ring-red-600 outline-none">
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-zinc-800 space-y-6">
            <h3 class="text-red-500 font-bold uppercase tracking-wider text-xs">Step 2: {{ $role === 'employee' ? 'Employee Details' : 'Company Details' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($role === 'employee')
                    <div class="space-y-1">
                        <label class="text-sm text-zinc-400 block">Gender</label>
                        <select wire:model="gender" class="w-full bg-zinc-950 border {{ $errors->has('gender') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white outline-none">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm text-zinc-400 block">Date of Birth</label>
                        <input type="date" wire:model="date_of_birth" class="w-full bg-zinc-950 border {{ $errors->has('date_of_birth') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white outline-none">
                        @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm text-zinc-400 block">Designation</label>
                        <input type="text" wire:model="designation" class="w-full bg-zinc-950 border {{ $errors->has('designation') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white outline-none">
                        @error('designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm text-zinc-400 block">Department</label>
                        <input type="text" wire:model="department" class="w-full bg-zinc-950 border {{ $errors->has('department') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white outline-none">
                        @error('department') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-sm text-zinc-400 block">Joining Date</label>
                        <input type="date" wire:model="joining_date" class="w-full bg-zinc-950 border {{ $errors->has('joining_date') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white outline-none">
                        @error('joining_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 p-4 bg-zinc-950/50 rounded-2xl border border-zinc-800 mt-4">
                        <h4 class="text-white text-sm font-bold mb-4">Banking Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <input type="text" placeholder="Bank Name" wire:model="bank_name" class="w-full bg-zinc-950 border {{ $errors->has('bank_name') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white text-sm outline-none">
                                @error('bank_name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1">
                                <input type="text" placeholder="Account Number" wire:model="account_number" class="w-full bg-zinc-950 border {{ $errors->has('account_number') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white text-sm outline-none">
                                @error('account_number') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @else
                    <div class="md:col-span-2 space-y-4">
                        <div class="space-y-1">
                            <label class="text-sm text-zinc-400 block">Company Name</label>
                            <input type="text" wire:model="company_name" class="w-full bg-zinc-950 border {{ $errors->has('company_name') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white outline-none">
                            @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm text-zinc-400 block">Industry</label>
                            <input type="text" wire:model="industry" class="w-full bg-zinc-950 border {{ $errors->has('industry') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white outline-none">
                            @error('industry') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="pt-8 border-t border-zinc-800">
            <div class="space-y-1">
                <label class="text-sm text-zinc-400 block">Create Password</label>
                <input type="password" wire:model="password" class="w-full bg-zinc-950 border {{ $errors->has('password') ? 'border-red-500' : 'border-zinc-800' }} rounded-xl p-3 text-white focus:ring-2 focus:ring-red-600 outline-none">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        @if ($errors->any())
    <div class="bg-white p-4 text-black">
        <strong>Debug Errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        @if ($errors->any())
            <div class="p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
                <p class="text-red-500 text-xs font-bold">Please correct the highlighted errors before submitting.</p>
            </div>
        @endif

        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-4 rounded-xl font-bold transition-all shadow-xl shadow-red-900/20">
            <span wire:loading.remove>Verify & Register Account</span>
            <span wire:loading>Processing...</span>
        </button>
    </form>

</div>