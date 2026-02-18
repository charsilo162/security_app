<div>
    @if(!$loading && !empty($stats))
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-dashboard.stat-card
                icon="📥"
                title="Pending Request"
                :value="$stats['service_metrics']['pending'] ?? 0"
                sub="Service requests"
            />
            <x-dashboard.stat-card
                icon="✅"
                title="Completed"
                :value="$stats['service_metrics']['completed'] ?? 0"
                sub="Services finished"
            />
            <x-dashboard.stat-card
                icon="⏱"
                title="Total Service"
                :value="$stats['service_metrics']['total_requests'] ?? 0"
                sub="Lifetime requests"
            />
             <x-dashboard.stat-card
                icon="👥"
                title="Total Clients"
                :value="$stats['client_metrics']['total_clients'] ?? 0"
                sub="Registered businesses"
            />
        </div>

        <hr class="my-6 border-gray-200">

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-dashboard.stat-card
                icon="📅"
                title="Active Staff"
                :value="$stats['hr_metrics']['total_employees'] ?? 0"
                sub="{{ $stats['hr_metrics']['guards_count'] ?? 0 }} Guards active"
            />
            <x-dashboard.stat-card
                icon="✍️"
                title="Total Blogs"
                :value="$stats['blog_metrics']['total'] ?? 0"
                sub="{{ $stats['blog_metrics']['published'] ?? 0 }} Published"
            />
            <x-dashboard.stat-card
                icon="🔓"
                title="Pending Leaves"
                :value="$stats['leave_metrics']['pending'] ?? 0"
                sub="Staff leave requests"
            />
            <x-dashboard.stat-card
                icon="📝"
                title="Draft Posts"
                :value="$stats['blog_metrics']['drafts'] ?? 0"
                sub="In the works"
            />
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-pulse">
            @for($i=0; $i<8; $i++)
                <div class="h-32 bg-gray-100 rounded-xl"></div>
            @endfor
        </div>
    @endif
</div>