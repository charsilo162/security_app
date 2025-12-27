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

<div class="flex">

    <!-- SIDEBAR -->
    <x-dashboard.sidebar />

    <!-- OVERLAY (MOBILE) -->
    <div
        x-show="$store.ui.sidebarOpen"
        @click="$store.ui.closeSidebar()"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 z-30 md:hidden"
    ></div>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col min-h-screen">

        <!-- TOPBAR -->
        <x-dashboard.topbar />

        <!-- PAGE CONTENT -->
        <main class="p-6">
            {{ $slot }}
        </main>

    </div>
</div>

@livewireScripts
</body>
</html>
