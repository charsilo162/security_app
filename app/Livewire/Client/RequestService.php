<?php
namespace App\Livewire\Client;

use Livewire\Component;
use App\Services\ApiService;

class RequestService extends Component
{
    public int $step = 1;
    
    // Form fields
    public $title, $category, $required_staff_count, $start_date, $end_date, $description;

    protected ApiService $api;
    public function boot(ApiService $api) { $this->api = $api; }

    public function nextStep() { $this->step++; }
    public function prevStep() { $this->step--; }

public function submitRequest()
{
    $payload = [
        'title'                => $this->title,
        'category'             => $this->category,
        'required_staff_count' => $this->required_staff_count,
        'start_date'           => $this->start_date,
        'end_date'             => $this->end_date,
        'description'          => $this->description,
    ];

    $response = $this->api->post("client/requests", $payload);
dd( $response);
    if (isset($response['errors'])) {
        // Clear previous errors to avoid ghost messages
        $this->resetErrorBag();

        foreach ($response['errors'] as $field => $messages) {
            // This handles 'category', 'end_date', 'title', etc.
            // It takes the first error message for that field
            $this->addError($field, $messages[0]);
        }
        
        // Optional: Show a general toast for the main message
        $this->dispatch('notify', type: 'error', message: $response['message']);
        return;
    }

    return redirect()->route('client.dashboard')->with('success', 'Request Sent!');
}

    public function render()
    {
        return view('livewire.client.request-service');
    }
}