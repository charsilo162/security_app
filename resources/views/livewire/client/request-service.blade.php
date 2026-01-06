<div class="max-w-3xl mx-auto p-6">
    {{-- Stepper Header --}}
    <div class="mb-10">
        <div class="flex items-center justify-between relative">
            <div class="w-full absolute top-1/2 h-0.5 bg-zinc-200 dark:bg-zinc-800 -z-0"></div>
            
            @foreach(['Mission Details', 'Schedule', 'Review'] as $i => $label)
                @php $currentStep = $i + 1; @endphp
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300
                        {{ $step >= $currentStep ? 'bg-indigo-600 text-white shadow-lg ring-4 ring-indigo-50 dark:ring-indigo-900/30' : 'bg-zinc-200 text-zinc-500' }}">
                        @if($step > $currentStep) <i class="fas fa-check"></i> @else {{ $currentStep }} @endif
                    </div>
                    <span class="text-xs font-bold mt-2 uppercase tracking-wider {{ $step >= $currentStep ? 'text-indigo-600' : 'text-zinc-400' }}">
                        {{ $label }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-zinc-900 rounded-3xl border dark:border-zinc-800 shadow-xl overflow-hidden">
        <div class="p-8">
            
            {{-- STEP 1: Basic Info --}}
            @if($step == 1)
            <div class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-300">
                <div>
                    <h2 class="text-2xl font-bold">Mission Details</h2>
                    <p class="text-zinc-500 text-sm">Tell us what kind of security coverage you need.</p>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Mission Title</label>
                        <input wire:model="title" type="text" placeholder="e.g. Executive Protection for AGM" 
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Category</label>
                            <select wire:model="category" class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Service Type</option>
                                <option value="armed">Armed Guard</option>
                                <option value="unarmed">Unarmed Guard</option>
                                <option value="escort">VIP Escort</option>
                                <option value="event">Event Security</option>

                            </select>
                            @error('category') 
                                <span class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> 
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Staff Count</label>
                            <input wire:model="required_staff_count" type="number" placeholder="Number of guards" 
                                class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- STEP 2: Schedule & Description --}}
            @if($step == 2)
            <div class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-300">
                <div>
                    <h2 class="text-2xl font-bold">Timeframe & Briefing</h2>
                    <p class="text-zinc-500 text-sm">When and where should our team report?</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Start Date</label>
                        <input wire:model="start_date" type="date" class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">End Date</label>
                        <input wire:model="end_date" type="date" class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Special Instructions</label>
                    <textarea wire:model="description" rows="4" placeholder="Mention any specific protocols or dress codes..." 
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
            </div>
            @endif

            {{-- STEP 3: Review --}}
            @if($step == 3)
            <div class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-300">
                <div>
                    <h2 class="text-2xl font-bold">Review Request</h2>
                    <p class="text-zinc-500 text-sm">Please confirm the details before submitting.</p>
                </div>

                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-3xl space-y-4">
                    <div class="flex justify-between border-b border-indigo-100 dark:border-indigo-800 pb-2">
                        <span class="text-zinc-500 text-sm">Title</span>
                        <span class="font-bold">{{ $title }}</span>
                    </div>
                    <div class="flex justify-between border-b border-indigo-100 dark:border-indigo-800 pb-2">
                        <span class="text-zinc-500 text-sm">Personnel</span>
                        <span class="font-bold">{{ $required_staff_count }} {{ $category }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500 text-sm">Duration</span>
                        <span class="font-bold">{{ $start_date }} to {{ $end_date }}</span>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Footer Buttons --}}
        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 flex justify-between items-center">
            @if($step > 1)
                <button wire:click="prevStep" class="text-zinc-500 font-bold hover:text-black dark:hover:text-white transition">
                    Back
                </button>
            @else
                <div></div>
            @endif

            <div class="flex gap-4">
                @if($step < 3)
                    <button wire:click="nextStep" class="bg-zinc-900 dark:bg-white dark:text-zinc-900 text-white px-8 py-3 rounded-2xl font-bold shadow-lg">
                        Continue
                    </button>
                @else
                    <button wire:click="submitRequest" wire:loading.attr="disabled" class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition flex items-center gap-2">
                        <span wire:loading.remove>Submit Request</span>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> Sending...</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>