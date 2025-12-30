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

    public function loadEmployee()
    {
        $response = $this->api->get("employees/{$this->uuid}");
        //dd($response);
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