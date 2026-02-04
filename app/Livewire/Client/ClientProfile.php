<?php
namespace App\Livewire\Client;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class ClientProfile extends Component
{
    public $client;

    public function mount(ApiService $api)
    {
        // 1. Get the UUID stored during login
        $user = Session::get('user');
        $uuid = $user['profile_uuid'] ?? null;

        if (!$uuid) {
            abort(403, 'Profile not found in session.');
        }

        // 2. Fetch client details from the API
        $response = $api->get("admin/clients/{$uuid}");

        if (isset($response['data'])) {
            $this->client = $response['data'];
        } else {
            session()->flash('error', 'Could not load profile.');
        }
    }

    public function render()
    {
        return view('livewire.client.client-profile'); // Use your dashboard layout
    }
}