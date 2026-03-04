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
    public $employeeSearch = '';
    public $showChatModal = false;

    protected $messages = [
    'selectedEmployees.required' => 'Please select at least one guard to assign.',
    'selectedEmployees.min' => 'Please select at least one guard to assign.',
    'selectedEmployees.max' => 'You cannot assign more than the requested number of guards.',
    ];
 
    /**
     * Open the assignment modal and fetch available personnel
     */
    public function openChat($uuid) 
        {
            // We fetch the request just to get the title/details for the modal header
            $response = $this->api->get("admin/requests/{$uuid}");
            
            if (isset($response['data'])) {
                $this->selectedRequest = $response['data']; 
                // We use the UUID as the missionId for the chat component
                $this->showChatModal = true;
            }
        }
    public function fetchEmployees()
        {
            $params = [
                'per_page' => 100,
            ];

            if (!empty($this->employeeSearch)) {
                $params['search'] = $this->employeeSearch;
            }

            $empResponse = $this->api->get("employees", $params);

            $this->availableEmployees = $empResponse['data'] ?? [];
        }

            public function updatedEmployeeSearch()
            {
                logger('Search updated: ' . $this->employeeSearch);

                $this->fetchEmployees();
            }
    public function openAssignModal($uuid)
        {
            $this->reset(['selectedEmployees', 'adminRemarks', 'employeeSearch']);

            $response = $this->api->get("admin/requests/{$uuid}");
            $this->selectedRequest = $response['data'];

            $this->fetchEmployees(); // load initial employees

            $this->showModal = true;
        }

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
            $requiredCount = $this->selectedRequest['required_staff_count'] ?? 0;

            $this->validate([
                'selectedEmployees' => [
                    'required',
                    'array',
                    'min:1',
                    'max:' . $requiredCount,
                ],
            ], [
                'selectedEmployees.required' => 'Please select at least one guard to assign.',
                'selectedEmployees.min' => 'Please select at least one guard to assign.',
                'selectedEmployees.max' => "You cannot assign more than {$requiredCount} guards as per the client's request.",
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