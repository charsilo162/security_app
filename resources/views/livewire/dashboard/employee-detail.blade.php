<div class="p-6 bg-zinc-50 dark:bg-zinc-950 min-h-screen">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border dark:border-zinc-800">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-bold text-lg">Personal Information</h3>
                <button class="text-zinc-400"><i class="fas fa-ellipsis-v"></i></button>
            </div>

            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-50 mb-4">
                    <img src="{{ $employee['photo'] ?? 'https://ui-avatars.com/api/?name='.urlencode($employee['full_name']) }}" class="w-full h-full object-cover">
                </div>
                <h2 class="text-xl font-bold">{{ $employee['full_name'] }}</h2>
                <p class="text-indigo-600 font-medium">{{ $employee['designation'] }}</p>
                
                <div class="flex gap-2 mt-4">
                    <span class="w-8 h-8 rounded bg-orange-50 text-orange-500 flex items-center justify-center text-xs"><i class="fab fa-x-twitter"></i></span>
                    <span class="w-8 h-8 rounded bg-blue-50 text-blue-500 flex items-center justify-center text-xs"><i class="fab fa-facebook-f"></i></span>
                    <span class="w-8 h-8 rounded bg-sky-50 text-sky-500 flex items-center justify-center text-xs"><i class="fab fa-linkedin-in"></i></span>
                </div>
            </div>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between py-2 border-b dark:border-zinc-800">
                    <span class="text-zinc-500">Employee ID:</span>
                    <span class="font-semibold">{{ $employee['employee_code'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b dark:border-zinc-800">
                    <span class="text-zinc-500">Date of Join:</span>
                    <span class="font-semibold">{{ $employee['joining_date'] }}</span>
                </div>
                <div class="flex justify-between py-2 border-b dark:border-zinc-800">
                    <span class="text-zinc-500">Email:</span>
                    <span class="font-semibold truncate ml-4">{{ $employee['email'] }}</span>
                </div>
                <div class="flex justify-between py-2 border-b dark:border-zinc-800">
                    <span class="text-zinc-500">Phone:</span>
                    <span class="font-semibold">{{ $employee['phone'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b dark:border-zinc-800">
                    <span class="text-zinc-500">Gender:</span>
                    <span class="font-semibold capitalize">{{ $employee['gender'] ?? 'N/A' }}</span>
                </div>
                <div class="py-2">
                    <span class="text-zinc-500 block mb-1">Address:</span>
                    <p class="font-semibold leading-relaxed">{{ $employee['address'] ?? 'No address provided' }}</p>
                </div>
            </div>

            {{-- <button class="w-full mt-6 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                Send Message
            </button> --}}
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border dark:border-zinc-800">
             <div class="flex justify-between items-start mb-6">
                <h3 class="font-bold text-lg">About & Professional</h3>
                <button class="text-zinc-400"><i class="fas fa-ellipsis-v"></i></button>
            </div>

            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg"><i class="fas fa-user-tie"></i></div>
                    <div>
                        <h4 class="font-bold">Professional Bio</h4>
                        <p class="text-xs text-zinc-400">Department: {{ $employee['department'] }}</p>
                    </div>
                </div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-loose italic">
                    "{{ $employee['bio'] ?? 'No bio available for this employee.' }}"
                </p>
            </div>

            <div>
                 <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg"><i class="fas fa-university"></i></div>
                    <div>
                        <h4 class="font-bold">Banking Details</h4>
                        <p class="text-xs text-zinc-400">Payroll Information</p>
                    </div>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-lg space-y-3 text-sm">
                    <p><span class="text-zinc-500">Bank:</span> {{ $employee['banking']['bank_name'] ?? 'N/A' }}</p>
                    <p><span class="text-zinc-500">Account:</span> ****{{ substr($employee['banking']['account_number'] ?? '', -4) }}</p>
                    <p><span class="text-zinc-500">Holder:</span> {{ $employee['banking']['account_holder_name'] ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border dark:border-zinc-800">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-bold text-lg">Timeline & Activity</h3>
                <button class="text-zinc-400"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            
            <div class="relative pl-6 border-l-2 border-zinc-100 dark:border-zinc-800 space-y-8">
                <div class="relative">
                    <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-indigo-600 border-4 border-white dark:border-zinc-900"></div>
                    <p class="text-xs text-zinc-400 mb-1">Joined Company</p>
                    <h5 class="font-bold text-sm">{{ $employee['joining_date'] }}</h5>
                </div>
                <div class="relative">
                    <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-zinc-300 border-4 border-white dark:border-zinc-900"></div>
                    <p class="text-xs text-zinc-400 mb-1">Last Profile Update</p>
                    <h5 class="font-bold text-sm">December 2025</h5>
                </div>
            </div>
        </div>

    </div>
</div>