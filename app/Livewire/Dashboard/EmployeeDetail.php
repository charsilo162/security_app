<?php
namespace App\Livewire\Dashboard;

use App\Services\ApiService;
use Livewire\Component;

class EmployeeDetail extends Component
{
    public $uuid;
    public $employee = [];
    protected $api;

    public function boot(ApiService $api)
    {
        $this->api = $api;
    }

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->loadEmployee();
    }
public function openDirectChat($employeeUuid)
{
   // dd("Attempting to start chat with employee UUID: {$employeeUuid}");
    // Check if user_id actually exists
    if (!isset($this->employee['user_id'])) {
        dd($this->employee);
        session()->flash('error', 'User ID not found for this employee.');
        return;
    }

    $response = $this->api->post('chat/start', [
        'employee_user_id' => $this->employee['user_id'] 
    ]);
        // dd( $response);
    if (isset($response['data']['uuid'])) {
        return redirect()->route('admin.direct-chat', ['targetUuid' => $response['data']['uuid']]);
    } else {
        // Debug what the API actually said
        logger($response); 
    }
}
    public function loadEmployee()
    {
        $response = $this->api->get("employees/{$this->uuid}");
        // dd($response);
        if (isset($response['data'])) {
            $this->employee = $response['data'];
        } else {
            abort(404, 'Employee not found');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.employee-detail');
    }
}