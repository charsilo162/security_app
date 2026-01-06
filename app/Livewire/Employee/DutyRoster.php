<?php


namespace App\Livewire\Employee;

use Livewire\Component;
use App\Traits\ApiTableActions;

class DutyRoster extends Component
{
    use ApiTableActions;


    public function confirmAttendance($uuid)
{
    // 1. Send request to API to mark attendance as 'confirmed'
    $response = $this->api->patch("employee/assignments/{$uuid}/confirm");
// dd($response);
    if (isset($response['errors'])) {
        $this->dispatch('notify', type: 'error', message: 'Confirmation failed.');
        return;
    }

    $this->dispatch('notify', type: 'success', message: 'Duty Confirmed. Stay safe!');
  
}
    public function render()
    {
        // Hits our new endpoint
        $response = $this->api->get('employee/roster', [
            'per_page' => $this->perPage,
            'page' => $this->getPage(),
        ]);
    // dd($response);

        return view('livewire.employee.duty-roster', [
            'assignments' => $response['data'] ?? [],
        ]);
    }
}