<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    x-data="{
        dark: localStorage.getItem('dark') === 'true',
        sidebarOpen: false
    }"
    x-init="$watch('dark', v => localStorage.setItem('dark', v))"
    :class="dark ? 'dark' : ''"
    class="bg-zinc-100 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100"
>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <x-dashboard.sidebar />

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <x-dashboard.topbar />

        <!-- CONTENT -->
        <main class="flex-1 p-6 bg-zinc-50 dark:bg-zinc-800">
            {{ $slot }}
        </main>

    </div>
</div>


@livewireScripts
@stack('scripts')
</body>
</html>
