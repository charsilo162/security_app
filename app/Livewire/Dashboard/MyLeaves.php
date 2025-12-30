<?php
namespace App\Livewire\Dashboard;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\WithFileUploads;

class MyLeaves extends Component
{
    use WithFileUploads;

    public $balances = [];
    public $leave_type_id, $start_date, $end_date, $reason, $attachment;
    public $showApplyModal = false;

    protected $api;

    public function boot(ApiService $api) 
    {
        $this->api = $api;
    }

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Get the specific balances for the logged-in employee
        $this->balances = $this->api->get('leave-balances'); 
    }

    public function submitRequest()
    {
        $this->validate([
            'leave_type_id' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|min:10',
        ]);

        $response = $this->api->post('leaves', [
            'leave_type_id' => $this->leave_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'reason' => $this->reason,
        ]);

        if (isset($response['uuid'])) {
            $this->dispatch('notify', type: 'success', message: 'Request submitted successfully!');
            $this->reset(['leave_type_id', 'start_date', 'end_date', 'reason', 'showApplyModal']);
            $this->loadData();
        }
    }

    public function render()
    {
        // Fetch only this employee's history
        $history = $this->api->get('my-leaves'); 
//dd($history);
        return view('livewire.dashboard.my-leaves', [
            'history' => $history['data'] ?? []
        ]);
    }
}

//https://gemini.google.com/app/83f6b2bd3ae8c084