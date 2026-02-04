<aside
    class="fixed md:static inset-y-0 left-0 z-40 w-64
           bg-white dark:bg-zinc-900
           border-r border-zinc-200 dark:border-zinc-800
           transform transition-transform duration-300"
    :class="$store.ui.sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
>

    {{-- Logo / Header --}}
    <div class="h-16 flex items-center justify-between px-6 border-b dark:border-zinc-800">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-shield-alt text-white text-sm"></i>
            </div>
              <a href="{{ route('home') }}">
            <span class="font-bold tracking-tight text-zinc-900 dark:text-white">NSG Portal</span>
              </a>
        </div>

        <button @click="$store.ui.closeSidebar()" class="md:hidden text-zinc-500 hover:text-zinc-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

<nav class="p-4 space-y-1 text-sm font-medium">
    @php
        $userType = session('user.type');

       
   $activeClass = "
    bg-indigo-50 text-indigo-700
    dark:bg-indigo-900/30 dark:text-indigo-300
";

$inactiveClass = "
    text-zinc-700
    hover:bg-zinc-100 hover:text-zinc-900
    dark:text-zinc-300
    dark:hover:bg-zinc-700/60 dark:hover:text-white
";

$baseClass = "
    flex items-center gap-3 px-4 py-2.5
    rounded-xl
    transition-colors duration-200
    group
";

    @endphp

    {{-- 1. ADMIN SECTION (prefix: dashboard, name: admin.) --}}
    @if($userType === 'admin')
        <div class="pb-2 px-4 mt-2">
            <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Administration</span>
        </div>

        {{-- <a href="{{ route('admin.index') }}" class="{{ $baseClass }} {{ request()->routeIs('admin.index') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-th-large w-5"></i> Dashboard
        </a> --}}

        <a href="{{ route('admin.employees') }}" class="{{ $baseClass }} {{ request()->routeIs('admin.employees') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-users-cog w-5"></i> Manage Staff
        </a>

        <a href="{{ route('admin.clients') }}" class="{{ $baseClass }} {{ request()->routeIs('admin.clients') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-building w-5"></i> Client List
        </a>

        <a href="{{ route('admin.requests') }}" class="{{ $baseClass }} {{ request()->routeIs('admin.requests') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-clipboard-list w-5"></i> Service Requests
        </a>

        {{-- FIXED: Matches name('admin.')...name('leaves.manage') --}}
        <a href="{{ route('admin.leaves.manage') }}" class="{{ $baseClass }} {{ request()->routeIs('admin.leaves.manage') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-calendar-check w-5"></i> Review Leaves
        </a>

        <a href="{{ route('admin.posts.index') }}" class="{{ $baseClass }} {{ request()->routeIs('admin.posts.index') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-newspaper w-5"></i> Posts
        </a>
    @endif

    {{-- 2. CLIENT SECTION (prefix: client, name: client.) --}}
    @if($userType === 'client')
      {{-- @php
        $userTID = session('user.profile_uuid');
    @endphp --}}
        <div class="pb-2 px-4 mt-2">
            <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Client Console</span>
        </div>

        <a href="{{ route('client.profile') }}" class="{{ $baseClass }} {{ request()->routeIs('client.profile') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-chart-line w-5"></i> My Profile
        </a>
        <a href="{{ route('client.dashboard') }}" class="{{ $baseClass }} {{ request()->routeIs('client.dashboard') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-chart-line w-5"></i> Overview
        </a>

        <a href="{{ route('client.request-service') }}" class="{{ $baseClass }} {{ request()->routeIs('client.request-service') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-plus-circle w-5"></i> Hire Security
        </a>

        <a href="{{ route('client.my-requests') }}" class="{{ $baseClass }} {{ request()->routeIs('client.my-requests') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-history w-5"></i> My History
        </a>
      
    @endif

    {{-- 3. EMPLOYEE SECTION (prefix: me, name: employee.) --}}
    @if($userType === 'employee')
    @php
        $userTID = session('user.profile_uuid');
    @endphp
        <div class="pb-2 px-4 mt-2">
            <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Guard Portal</span>
        </div>

        <a href="{{ route('employee.roster') }}" class="{{ $baseClass }} {{ request()->routeIs('employee.roster') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-calendar-alt w-5"></i> Duty Roster
        </a>

        {{-- FIXED: Matches name('employee.')...name('leaves.my-history') --}}
        <a href="{{ route('employee.leaves.my-history') }}" class="{{ $baseClass }} {{ request()->routeIs('employee.leaves.my-history') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-clock w-5"></i> My Leaves
        </a>
        <a href="{{ route('employee.employees.show', $userTID) }}" class="{{ $baseClass }} {{ request()->routeIs('client.my-requests') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-history w-5"></i> Employee Details
        </a>
      
    @endif

    {{-- LOGOUT --}}
    <div class="pt-4 mt-4 border-t dark:border-zinc-800">
        <livewire:auth.logout />
    </div>
</nav>
</aside>