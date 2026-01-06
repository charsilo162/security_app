<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Authentication' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-zinc-950 text-zinc-100 min-h-screen antialiased selection:bg-indigo-500/30 flex flex-col justify-center">
    
    <div class="max-w-md mx-auto w-full px-4">
        @if(session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-500/10 border border-red-500/50 text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{ $slot }}

    @livewireScripts
</body>
</html>