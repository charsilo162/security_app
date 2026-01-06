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
        $response = $this->api->get('client/dashboard-summary');
        
        $this->stats = $response['stats'] ?? [
            'active_guards' => 0,
            'pending_requests' => 0,
            'total_spent' => 0
        ];

        $this->recentRequests = $response['recent_requests'] ?? [];
    }

    public function render()
    {
        return view('livewire.client.dashboard');
    }
}