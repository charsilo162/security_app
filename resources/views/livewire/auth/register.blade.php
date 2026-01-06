<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Join Us</h2>

    <div class="flex mb-6 border-b">
        <button wire:click="setRole('client')" 
            class="flex-1 py-2 {{ $role === 'client' ? 'border-b-2 border-blue-500 font-bold' : 'text-gray-500' }}">
            Client Signup
        </button>
        <button wire:click="setRole('employee')" 
            class="flex-1 py-2 {{ $role === 'employee' ? 'border-b-2 border-blue-500 font-bold' : 'text-gray-500' }}">
            Employee Signup
        </button>
    </div>

    <form wire:submit.prevent="register" class="space-y-4">
        <input type="text" wire:model="first_name" placeholder="First Name" class="w-full border p-2 rounded">
        @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        
        <input type="email" wire:model="email" placeholder="Email" class="w-full border p-2 rounded">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        @if($role === 'client')
            <input type="text" wire:model="company_name" placeholder="Company Name" class="w-full border p-2 rounded">
            @error('company_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @endif

        @if($role === 'employee')
            <input type="text" wire:model="designation" placeholder="Designation (e.g. Developer)" class="w-full border p-2 rounded">
            @error('designation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @endif

        <input type="password" wire:model="password" placeholder="Password" class="w-full border p-2 rounded">
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Register as {{ ucfirst($role) }}
        </button>
    </form>
</div>