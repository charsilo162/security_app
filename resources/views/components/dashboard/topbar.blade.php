<header class="h-16 flex items-center justify-between px-6
               bg-white dark:bg-zinc-900
               border-b border-zinc-200 dark:border-zinc-800">

    <!-- LEFT -->
    <div class="flex items-center gap-4">
        <button
            @click="$store.ui.toggleSidebar()"
            class="md:hidden"
        >
            ☰
        </button>

        <input
            type="text"
            placeholder="Search..."
            class="hidden md:block px-4 py-2 rounded-lg
                   bg-zinc-100 dark:bg-zinc-800"
        />
    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-4">

        <!-- DARK MODE -->
        <button @click="$store.ui.toggleDark()">
            🌙
        </button>

        <!-- PROFILE -->
        <div class="flex items-center gap-2">
            <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full">
            <span class="hidden md:block">John Wick</span>
        </div>
    </div>
</header>
