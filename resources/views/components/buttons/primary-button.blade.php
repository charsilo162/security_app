@props([
    'href' => '#',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => '
            inline-flex items-center justify-center
            bg-red-600 hover:bg-red-700
            px-6 py-2.5 rounded-full
            text-sm font-semibold text-white
            transition-all duration-300 ease-[cubic-bezier(.16,1,.3,1)]
            hover:scale-[1.04] active:scale-[0.98]
        '
    ]) }}
>
    {{ $slot }}
</a>
