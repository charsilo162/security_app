<!DOCTYPE html>
{{-- <html lang="en" x-data> --}}
<html lang="en" x-data x-init="$store.ui.init()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    x-init="$store.ui.init()"
    class="bg-zinc-100 dark:bg-zinc-950
           text-zinc-900 dark:text-white
           min-h-screen overflow-x-hidden"
>

<div class="flex min-h-screen w-full">

    <x-dashboard.sidebar />

    <div
        x-show="$store.ui.sidebarOpen"
        @click="$store.ui.closeSidebar()"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 z-30 md:hidden"
    ></div>

    <div class="flex-1 flex flex-col min-w-0">

        <x-dashboard.topbar />

        <main class="p-6">
            {{ $slot }}
        </main>

    </div>
</div>

@livewireScripts
<div x-data="{ 
        show: false, 
        message: '', 
        type: 'success' 
    }"
    x-on:notify.window="
        show = true; 
        message = $event.detail.message; 
        type = $event.detail.type;
        setTimeout(() => show = false, 3000)
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    class="fixed bottom-5 right-5 z-[100]"
    style="display: none;"
>
    <div :class="{
            'bg-green-600': type === 'success',
            'bg-red-600': type === 'error',
            'bg-blue-600': type === 'info'
        }" 
        class="text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
        
        <span x-show="type === 'error'">⚠️</span>
        <span x-show="type === 'success'">✅</span>
        
        <span x-text="message" class="font-medium"></span>
    </div>
</div>
</body>
</html>
