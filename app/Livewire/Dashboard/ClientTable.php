<?php
namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\ApiService;
use Livewire\Attributes\On;

class ClientTable extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public int $perPage = 10;
    public bool $showModal = false;
    public ?string $editId = null; 

    // Client Fields (Balanced with your new migration)
    public $first_name, $last_name, $email, $phone, $address, $password;
    public $company_name, $industry, $registration_number, $photo, $currentPhotoUrl;

    protected ApiService $api;
    public function boot(ApiService $api) { $this->api = $api; }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['editId', 'first_name', 'last_name', 'email', 'phone', 'address', 'company_name', 'industry', 'registration_number', 'password', 'photo']);
        $this->showModal = true;
    }

    public function openEditModal($uuid)
    {
        $this->resetValidation();
        $this->editId = $uuid;
        $response = $this->api->get("admin/clients/{$uuid}");

        if (isset($response['status']) && $response['status'] === 403) {
            return $this->dispatch('notify', type: 'error', message: 'Access Denied.');
        }
// dd($response);
        $client = $response['data'];
        $this->first_name = $client['first_name'];
        $this->last_name  = $client['last_name'];
        $this->email      = $client['email'];
        $this->phone      = $client['phone'];
        $this->address    = $client['address'];
        $this->company_name = $client['company_name'];
        $this->industry     = $client['industry'];
        $this->registration_number = $client['registration_number'];
        $this->currentPhotoUrl = $client['photo'] ?? null;

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'first_name'   => 'required|string',
            'company_name' => 'required|string',
            'email'        => 'required|email',
            'phone'        => 'required',
        ]);

        $payload = [
            ['name' => 'first_name',   'contents' => $this->first_name],
            ['name' => 'last_name',    'contents' => $this->last_name],
            ['name' => 'email',        'contents' => $this->email],
            ['name' => 'phone',        'contents' => $this->phone],
            ['name' => 'address',      'contents' => $this->address],
            ['name' => 'company_name', 'contents' => $this->company_name],
            ['name' => 'industry',     'contents' => $this->industry],
            ['name' => 'registration_number', 'contents' => $this->registration_number],
            ['name' => 'type',         'contents' => 'client'], // Hardcoded for this component
        ];

        if ($this->editId) {
            $payload[] = ['name' => '_method', 'contents' => 'PUT'];
        }
        if ($this->password) {
            $payload[] = ['name' => 'password', 'contents' => $this->password];
        }

        $response = $this->editId 
            ? $this->api->postWithFile("admin/clients/{$this->editId}", $payload)
            : $this->api->postWithFile("admin/clients", $payload);

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        $this->dispatch('notify', type: 'success', message: $this->editId ? 'Client Updated' : 'Client Created');
        $this->showModal = false;
    }
        public function deleteClient($uuid)
        {
            // 1. Call the API
            $response = $this->api->delete("admin/clients/{$uuid}");

            if (isset($response['errors'])) {
                $this->dispatch('notify', type: 'error', message: 'Could not delete client.');
                return;
            }

            // 2. Refresh the table and notify
            $this->dispatch('notify', type: 'success', message: 'Client and associated user removed.');
        }
    public function render()
    {
        $response = $this->api->get('admin/clients', [
            'search' => $this->search,
            'per_page' => $this->perPage,
            'page' => $this->getPage(),
        ]);
// dd($response);
        return view('livewire.dashboard.client-table', [
            'clients' => $response['data'] ?? [],
            'total'   => $response['meta']['total'] ?? 0
        ]);
    }
}