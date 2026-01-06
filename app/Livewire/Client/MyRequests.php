<?php
namespace App\Livewire\Client;

use Livewire\Component;
use App\Traits\ApiTableActions;

class MyRequests extends Component
{
    use ApiTableActions;

    public function render()
    {
        // Hits the GET /client/requests endpoint which filters by Auth::id()
        $response = $this->api->get('client/requests', [
            'search' => $this->search,
            'per_page' => $this->perPage,
            'page' => $this->getPage(),
        ]);
//dd($response);
        return view('livewire.client.my-requests', [
            'requests' => $response['data'] ?? [],
            'total' => $response['meta']['total'] ?? 0
        ]);
    }
}