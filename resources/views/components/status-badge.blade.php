@props(['status'])

@php
    $classes = match($status) {
        'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
        'assigned'  => 'bg-blue-50 text-blue-700 border-blue-200',
        'active'    => 'bg-green-50 text-green-700 border-green-200',
        'completed' => 'bg-zinc-50 text-zinc-700 border-zinc-200',
        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
        default     => 'bg-gray-50 text-gray-700 border-gray-200',
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2.5 py-0.5 rounded-full text-xs font-medium border $classes"]) }}>
    {{ ucfirst($status) }}
</span>