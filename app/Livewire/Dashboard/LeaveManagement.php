<?php

namespace App\Livewire\Dashboard;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveManagement extends Component
{
    use WithPagination;

    public $stats = [];
    public $search = '';
    public $filterStatus = '';
    public $selectedRequest = null; // For the Approval Modal
    public $adminRemarks = '';
    
    protected $api;

    public function boot(ApiService $api) 
    {
        $this->api = $api;
    }

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = $this->api->get('leave-stats');
    }

    // --- Action: Open Approval Modal ---
    public function reviewRequest($uuid)
    {
        $response = $this->api->get("leaves/{$uuid}");
        //dd( $response);
        $this->selectedRequest = $response['data'];
        $this->dispatch('open-modal', name: 'review-modal');
    }

    // --- Action: Update Status ---
    public function updateStatus($status)
    {
        $uuid = $this->selectedRequest['uuid'];
        
        $response = $this->api->patch("leaves/{$uuid}/status", [
            'status' => $status,
            'remarks' => $this->adminRemarks
        ]);

        if (isset($response['message'])) {
            $this->dispatch('notify', type: 'success', message: "Leave {$status} successfully");
            $this->dispatch('close-modal');
            $this->loadStats(); // Refresh top cards
            $this->reset(['selectedRequest', 'adminRemarks']);
        }
    }
        public function revertToPending($uuid)
            {
                // We send a PATCH request to set status back to pending
                $response = $this->api->patch("leaves/{$uuid}/status", [
                    'status' => 'pending',
                    'remarks' => 'Status reverted by HR'
                ]);

                if (isset($response['message'])) {
                    $this->dispatch('notify', type: 'success', message: 'Request has been reset to pending.');
                    $this->loadStats(); // Refresh the top counts (Approved/Pending)
                }
            }
    public function render()
    {
        $response = $this->api->get('leaves', [
            'status' => $this->filterStatus,
            'search' => $this->search,
            'page' => $this->getPage(),
        ]);

        return view('livewire.dashboard.leave-management', [
            'requests' => $response['data'] ?? [],
            'pagination' => $response['meta'] ?? []
        ]);
    }
}