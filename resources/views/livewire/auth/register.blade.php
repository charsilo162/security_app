<div class="min-h-screen flex items-center justify-center bg-white font-sans">

    <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-10 px-6 py-10">

        <!-- LEFT SIDE — FORM -->
        <div class="space-y-6">

            <h2 class="text-3xl font-semibold text-gray-800">Create your account</h2>

            <form wire:submit.prevent="register" class="space-y-4" enctype="multipart/form-data">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" wire:model="name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-400 focus:outline-none">
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-400 focus:outline-none">
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

             
          {{-- OPTIONAL PROFILE PHOTO --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo (optional)</label>
                <input type="file" wire:model="photo" accept="image/*"
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 bg-white">
                @error('photo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- 📸 TEMPORARY IMAGE PREVIEW SECTION 📸 --}}
            @if ($photo)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image Preview</label>
                    <img 
                        src="{{ $photo->temporaryUrl() }}" 
                        class="w-32 h-32 object-cover rounded-full border-2 border-sky-400 shadow-md" 
                        alt="Profile Photo Preview"
                    >
                </div>
            @endif
                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" wire:model="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-400 focus:outline-none">
                    @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Re-type Password</label>
                    <input type="password" wire:model="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" wire:model="phone"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 rounded-lg transition disabled:opacity-60"
                    wire:loading.attr="disabled">

                    <span wire:loading.remove>Sign up</span>

                    <span wire:loading class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l-3 3 3 3v-4a8 8 0 01-8-8z">
                            </path>
                        </svg>
                        Processing...
                    </span>

                </button>

                <p class="text-sm text-gray-600 text-center">
                    Already have an account?
                    <a href="{{ route('logins') }}" class="text-sky-500 hover:underline">Sign in</a>
                </p>
            </form>
        </div>

        <!-- RIGHT SIDE — STATIC BANNER IMAGE -->
        <div class="hidden md:flex items-center justify-center">
            <img src="{{ asset('storage/img3.png') }}"
                 class="w-full h-auto rounded-xl shadow-md object-cover" alt="Signup Banner">
        </div>

    </div>
</div>
