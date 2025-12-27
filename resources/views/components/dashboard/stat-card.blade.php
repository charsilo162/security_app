@props([
    'icon',
    'title',
    'value',
    'sub' => null,
    'trend' => null,
])

<div class="bg-white dark:bg-zinc-900
            border border-zinc-200 dark:border-zinc-800
            rounded-xl p-5 space-y-3">

    <div class="flex items-center justify-between">
        <div class="w-10 h-10 rounded-lg bg-zinc-100 dark:bg-zinc-800
                    flex items-center justify-center text-xl">
            {{ $icon }}
        </div>
    </div>

    <div>
        <p class="text-sm text-zinc-500">{{ $title }}</p>
        <p class="text-2xl font-semibold">{{ $value }}</p>
    </div>

    @if($sub)
        <p class="text-xs text-zinc-400">
            {!! $sub !!}
        </p>
    @endif
</div>
