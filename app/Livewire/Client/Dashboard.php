<?php
namespace App\Livewire\Client;

use Livewire\Component;
use App\Services\ApiService;

class Dashboard extends Component
{
    public $stats = [];
    public $recentRequests = [];
    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
        $this->api = $api; 
    }

    public function mount()
    {
        // We fetch the dashboard summary specifically for this client
        $response = $this->api->get('stat/service-stats');
       // dd($response['data']);
        $this->stats = $response['data'] ?? [
              "total" => 0,
            "pending_requests" => 0,
            "approved" => 0,
            "active" => 0,
            "completed" => 0,
            "cancelled" => 0,
        ];

        $this->recentRequests = $response['recent_requests'] ?? [];
    }

    public function render()
    {
        return view('livewire.client.dashboard');
    }
}