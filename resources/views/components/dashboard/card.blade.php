@props(['title'])

<div class="bg-white dark:bg-zinc-900
            border border-zinc-200 dark:border-zinc-800
            rounded-xl p-6">

    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold">{{ $title }}</h3>
        <button class="text-zinc-400">⋮</button>
    </div>

    {{ $slot }}
</div>
