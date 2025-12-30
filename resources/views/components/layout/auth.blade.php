<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Login' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body x-init="$store.ui.init()" class="bg-zinc-950 text-zinc-100 min-h-screen antialiased selection:bg-indigo-500/30">
    
        @if(session('error'))
    <div style="background: #f8d7da; color: #842029; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('error') }}
    </div>
    @endif

@if(session('success'))
    <div style="background: #d1e7dd; color: #0f5132; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif
    {{ $slot }}
    @livewireScripts

</body>
</html>
