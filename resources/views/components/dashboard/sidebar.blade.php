<aside
    class="fixed md:static inset-y-0 left-0 z-40 w-64
           bg-white dark:bg-zinc-900
           border-r border-zinc-200 dark:border-zinc-800
           transform transition-transform duration-300"
    :class="$store.ui.sidebarOpen
        ? 'translate-x-0'
        : '-translate-x-full md:translate-x-0'"
>

    <div class="h-16 flex items-center justify-between px-6 border-b dark:border-zinc-800">
        <span class="font-bold tracking-tight text-zinc-900 dark:text-white">NSG Admin</span>

        <button
            @click="$store.ui.closeSidebar()"
            class="md:hidden text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="p-4 space-y-1 text-sm font-medium">
        
        @php
            $activeClass = "bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white";
            $inactiveClass = "text-zinc-600 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200";
            $baseClass = "flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-200";
        @endphp

        <a href="{{ route('dashboard.index') }}" class="{{ $baseClass }} {{ request()->routeIs('dashboard.*') ? $activeClass : $inactiveClass }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('dashboard.posts.index') }}" class="{{ $baseClass }} {{ request()->routeIs('dashboard.posts.index') ? $activeClass : $inactiveClass }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
           Blog Post
        </a>
        <a href="{{ route('dashboard') }}" class="{{ $baseClass }} {{ request()->routeIs('dashboard.*') ? $activeClass : $inactiveClass }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            Employees
        </a>

        <a href="{{ route('leaves.my-history') }}" class="{{ $baseClass }} {{ request()->routeIs('leaves.my-history') ? $activeClass : $inactiveClass }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            My Leaves
        </a>

        @if((session('user.role') ?? session('user.type') ?? '') == 'admin')
            <div class="pt-4 pb-2 px-4">
                <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Admin Tools</span>
            </div>

            <a href="{{ route('admin.leaves.manage') }}" class="{{ $baseClass }} {{ request()->routeIs('admin.leaves.manage') ? $activeClass : $inactiveClass }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0112 2.714z" />
                </svg>
                Manage Leaves
            </a>
        @endif

    </nav>
</aside>