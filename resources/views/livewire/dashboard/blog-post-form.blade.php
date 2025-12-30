<div>
    @if($open)
<div class="fixed inset-0 z-50 flex">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/40" wire:click="close"></div>

    {{-- Slide-over --}}
    <div
        class="relative ml-auto w-full max-w-xl h-full bg-white dark:bg-zinc-900
               shadow-xl transform transition-all">

        {{-- Header --}}
        <div class="p-6 border-b dark:border-zinc-700 flex justify-between">
            <h2 class="text-lg font-semibold">Edit Blog Post</h2>

            <button wire:click="close" class="text-zinc-400 hover:text-zinc-600">
                ✕
            </button>
        </div>

        {{-- Form --}}
        <div class="p-6 space-y-4 overflow-y-auto h-[calc(100%-140px)]">

            <div>
                <label class="block text-sm mb-1">Title</label>
                <input
                    wire:model.defer="title"
                    class="w-full border rounded-lg px-3 py-2
                           dark:bg-zinc-800 dark:border-zinc-600"
                >
                @error('title') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Content</label>
                <textarea
                    wire:model.defer="content"
                    rows="10"
                    class="w-full border rounded-lg px-3 py-2
                           dark:bg-zinc-800 dark:border-zinc-600"></textarea>
                @error('content') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- Footer --}}
        <div class="p-6 border-t dark:border-zinc-700 flex justify-end gap-3">
            <button wire:click="close"
                class="px-4 py-2 border rounded-lg">
                Cancel
            </button>

            <button wire:click="save"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Save Changes
            </button>
        </div>
    </div>
</div>
@endif
</div>
