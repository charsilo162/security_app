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
    public $leaveTypes = [];


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
            $response = $this->api->get('leave-types');
            // dd($response);
            // Extract only the array of types
            $this->leaveTypes = $response['data'] ?? [];
            
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

            // CHANGE THIS LINE:
         if (isset($response['data']['uuid'])) {
                    // Switch from array to named arguments to match your working cancelRequest
                    $this->dispatch('notify', 
                        type: 'success', 
                        message: 'Request submitted successfully!'
                    );
                    
                    $this->showApplyModal = false;
                    $this->reset(['leave_type_id', 'start_date', 'end_date', 'reason']);
                    $this->loadData();
                } else {
                // Handle unexpected API error structure
                $this->dispatch('notify', [
                    'type' => 'error', 
                    'message' => $response['message'] ?? 'Something went wrong.'
                ]);
            }
        }


   public function cancelRequest($uuid)
        {
            $response = $this->api->delete("leaves/{$uuid}");

            if (isset($response['message'])) {
                $this->dispatch('notify', type: 'success', message: $response['message']);
                $this->loadData(); // Refresh history and balances
            } else {
                $this->dispatch('notify', type: 'error', message: 'Could not cancel request.');
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