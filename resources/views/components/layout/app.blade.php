<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Security Services' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gradient-to-b from-black via-zinc-900 to-zinc-950 text-white">

    {{ $slot }}
<div
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 800)"
    x-show="show"
    x-transition.opacity.scale.duration.500ms
    class="fixed bottom-6 right-6 z-50"
>
    <a
        href="https://wa.me/2348034567890"
        target="_blank"
        class="flex items-center gap-3 bg-green-600 hover:bg-green-500
               px-5 py-3 rounded-full shadow-2xl
               transition-all duration-500 ease-[cubic-bezier(.16,1,.3,1)]
               hover:scale-105"
    >
        <span class="text-xl">💬</span>
        <span class="font-semibold hidden md:inline">
            Chat on WhatsApp
        </span>
    </a>
</div>
<div
    x-data="{ show: false }"
    @scroll.window="show = window.scrollY > 600"
    x-show="show"
    x-transition.opacity.scale.duration.400ms
    class="fixed bottom-24 right-6 z-40"
>
    <button
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="w-12 h-12 rounded-full
               bg-black/80 border border-zinc-700
               text-white flex items-center justify-center
               hover:bg-red-600
               transition-all duration-500 ease-[cubic-bezier(.16,1,.3,1)]
               hover:scale-110"
    >
        ↑
    </button>
</div>

    @livewireScripts
    @stack('scripts')
    
</body>
</html>