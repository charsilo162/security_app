<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Log;

class StatsOverview extends Component
{
    public $stats = [];
    public $loading = true;

    public function mount(ApiService $api)
    {
        try {
            // Call the endpoint we created in the StatsController
            $response = $api->get("admin/stats");
            // dd($response);
            if (isset($response['success']) && $response['success']) {
                $this->stats = $response['data'];
            }
        } catch (\Exception $e) {
            Log::error("Stats API failed: " . $e->getMessage());
            session()->flash('error', 'Failed to load dashboard statistics.');
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.stats-overview');
    }
}