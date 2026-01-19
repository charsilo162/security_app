<?php
namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\ApiTableActions; // Using the Trait we discussed for DRY code
use Livewire\Attributes\On;

class ServiceRequestTable extends Component
{
    use ApiTableActions; // Handles pagination, search, api boot, and modal state

    // Assignment State
    public $selectedRequest = null;
    public array $selectedEmployees = []; // Array of IDs to be assigned
    public $availableEmployees = [];      // List of guards fetched from API
    public $adminRemarks = '';
    

    /**
     * Open the assignment modal and fetch available personnel
     */
    public function openAssignModal($uuid)
    {
        $this->reset(['selectedEmployees', 'adminRemarks']);
        
        // 1. Fetch the specific request details
        $response = $this->api->get("admin/requests/{$uuid}");
       // dd( $response);
        $this->selectedRequest = $response['data'];

        // 2. Fetch all employees to choose from
        // In a real scenario, you'd filter by 'available' status
        $empResponse = $this->api->get("employees", ['per_page' => 100]);
        $this->availableEmployees = $empResponse['data'] ?? [];

        $this->showModal = true;
    }
    // public function updateRequestStatus($uuid, $newStatus)
    //     {
    //         // Hits the PATCH /admin/requests/{uuid}/status endpoint in your API
    //         $response = $this->api->patch("admin/requests/{$uuid}/status", [
    //             'status' => $newStatus,
    //             'remarks' => "Status manually updated to {$newStatus} by Admin."
    //         ]);

    //         if (isset($response['errors'])) {
    //             $this->dispatch('notify', type: 'error', message: 'Status update failed.');
    //             return;
    //         }

    //         $this->dispatch('notify', type: 'success', message: "Mission marked as " . ucfirst($newStatus));
    //     }

        public function updateRequestStatus($uuid, $newStatus)
    {
        $response = $this->api->patch("admin/requests/{$uuid}/status", [
            'status' => $newStatus,
            'remarks' => "Status updated to {$newStatus} by Admin."
        ]);

        if (isset($response['errors'])) {
            $this->dispatch('notify', type: 'error', message: 'Status update failed.');
            return;
        }

        // Close modal if it was open (relevant for 'Cancelled' from modal footer)
        $this->showModal = false; 

        $this->dispatch('notify', type: 'success', message: "Mission marked as " . ucfirst($newStatus));
    }

    public function confirmAssignment()
    {
        $this->validate([
            'selectedEmployees' => 'required|array|min:1',
        ]);

        $payload = [
            'employee_ids' => $this->selectedEmployees,
            'remarks' => $this->adminRemarks,
            'status' => 'assigned'
        ];

        $response = $this->api->patch("admin/requests/{$this->selectedRequest['uuid']}/assign", $payload);

        if (isset($response['errors'])) {
            $this->dispatch('notify', type: 'error', message: 'Assignment failed.');
            return;
        }

        $this->showModal = false;
        // Reset selected employees so they don't stay checked for the next request
        $this->reset(['selectedEmployees', 'adminRemarks']); 
        
        $this->dispatch('notify', type: 'success', message: 'Security Personnel Assigned!');
    }
    /**
 * Quick action to approve a request before assignment
 */
    public function approveRequest($uuid)
        {
            $response = $this->api->patch("admin/requests/{$uuid}/status", [
                'status' => 'approved',
                'remarks' => 'Request verified by Admin.'
            ]);

            if (isset($response['errors'])) {
                $this->dispatch('notify', type: 'error', message: 'Failed to approve.');
                return;
            }

            $this->dispatch('notify', type: 'success', message: 'Mission Approved!');
        }
            /**
     * Submit the assignment to the Backend
     */
    // public function confirmAssignment()
    // {
    //     $this->validate([
    //         'selectedEmployees' => 'required|array|min:1',
    //     ]);

    //     $payload = [
    //         'employee_ids' => $this->selectedEmployees,
    //         'remarks' => $this->adminRemarks,
    //         'status' => 'assigned'
    //     ];

    //     // Using the PATCH route we defined in the backend
    //     $response = $this->api->patch("admin/requests/{$this->selectedRequest['uuid']}/assign", $payload);

    //     if (isset($response['errors'])) {
    //         $this->dispatch('notify', type: 'error', message: 'Assignment failed. Check availability.');
    //         return;
    //     }

    //     $this->dispatch('notify', type: 'success', message: 'Security Personnel Assigned!');
    //     $this->showModal = false;
    // }
  // Inside ServiceRequestTable.php

    // This hooks into Livewire's lifecycle to reset page on search update
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
        {
            $response = $this->api->get('admin/requests', [
                'search'   => $this->search,
                'per_page' => $this->perPage,
                'page'     => $this->getPage(), // Handled by WithPagination inside ApiTableActions
            ]);

            return view('livewire.dashboard.service-request-table', [
                'requests' => $response['data'] ?? [],
                'meta'     => $response['meta'] ?? [], // Meta contains links for pagination
                'total'    => $response['meta']['total'] ?? 0
            ]);
        }
}