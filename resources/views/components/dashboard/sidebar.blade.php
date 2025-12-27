<aside
    class="fixed md:static inset-y-0 left-0 z-40 w-64
           bg-white dark:bg-zinc-900
           border-r border-zinc-200 dark:border-zinc-800
           transform transition-transform duration-300"
    :class="$store.ui.sidebarOpen
        ? 'translate-x-0'
        : '-translate-x-full md:translate-x-0'"
>

    <!-- HEADER -->
    <div class="h-16 flex items-center justify-between px-6 border-b dark:border-zinc-800">
        <span class="font-bold">NSG Admin</span>

        <!-- CLOSE (MOBILE) -->
        <button
            @click="$store.ui.closeSidebar()"
            class="md:hidden text-xl"
        >
            ✕
        </button>
    </div>

    <!-- NAV -->
    <nav class="p-4 space-y-2 text-sm">
        <a class="block px-4 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
            Dashboard
        </a>
        <a class="block px-4 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
            Employees
        </a>
        <a class="block px-4 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
            Employees
        </a>
        <a class="block px-4 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
            Employees
        </a>
    </nav>
</aside>
