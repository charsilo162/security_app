<x-layout.dashboard title="Dashboard">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    <!-- STATS -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-dashboard.stat-card
            icon="📥"
            title="Pending Request"
            value="15"
            sub="<span class='text-red-500'>+3</span> since yesterday"
        />

        <x-dashboard.stat-card
            icon="✅"
            title="Completed Request"
            value="42"
            sub="<span class='text-green-500'>+12%</span> this week"
        />

        <x-dashboard.stat-card
            icon="⏱"
            title="Total Request"
            value="8.5"
            sub="this month"
        />

        <x-dashboard.stat-card
            icon="📅"
            title="Remaining Leave"
            value="12"
            sub="annual entitlement"
        />
    </div>

    <!-- TABLE -->
    <x-dashboard.card title="Company Request Overview">

        <x-ui.data-table
            :columns="['ID', 'Company', 'Security', 'Date', 'Priority', 'Action']"
            :rows="[
                ['id'=>1,'code'=>'#PRJ-1025','company'=>'E-commerce','security'=>3,'date'=>'15 Jul','priority'=>'High','action'=>'⋯'],
                ['id'=>2,'code'=>'#PRJ-1026','company'=>'Mobile App','security'=>10,'date'=>'25 Jul','priority'=>'Medium','action'=>'⋯'],
                ['id'=>3,'code'=>'#PRJ-1027','company'=>'Admin Dashboard','security'=>5,'date'=>'05 Aug','priority'=>'Low','action'=>'⋯'],
            ]"
        />

    </x-dashboard.card>

</x-layout.dashboard>
