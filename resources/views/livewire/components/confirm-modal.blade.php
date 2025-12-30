<div>
@if($open)
<div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 w-full max-w-md">

        <h2 class="text-lg font-semibold mb-4">
            Confirm Action
        </h2>

        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">
            Are you sure you want to continue? This action cannot be undone.
        </p>

        <div class="flex justify-end gap-3">
            <button wire:click="close"
                class="px-4 py-2 text-sm rounded-lg border">
                Cancel
            </button>

            <button wire:click="confirm"
                class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white">
                Confirm
            </button>
        </div>

    </div>
</div>
@endif
</div>
