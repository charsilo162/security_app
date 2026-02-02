<?php
namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class EmployeeTable extends Component
{
    use WithPagination,WithFileUploads;
   

    public string $search = '';
    public int $perPage = 10;
    
    // Modal & Action State
    public bool $showModal = false;
    public ?string $editId = null; 

    // ALL ORIGINAL FIELDS RESTORED
    public $first_name, $last_name, $employee_id, $joining_date, $email;
    public $phone, $designation, $department, $address;
    public $account_holder_name, $account_number, $bank_name;
    public $branch_name, $routing_number, $swift_code;
    

    public $gender, $bio, $date_of_birth, $password, $photo,$currentPhotoUrl;
    protected ApiService $api;

    public function boot(ApiService $api) { $this->api = $api; }

    // --- OPEN MODAL FOR ADD ---
    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(); // Clears all fields including editId
        $this->showModal = true;
    }

    // --- OPEN MODAL FOR EDIT ---
        public function openEditModal($uuid)
        {
            $this->resetValidation();
            $this->editId = $uuid; // We store the uuid as our reference
            $this->reset(['password', 'photo', 'currentPhotoUrl']);





                $response = $this->api->get("employees/{$uuid}");
                // dd($response);
                // Handle Policy Error
                if (isset($response['status']) && $response['status'] === 403) {
                    return $this->dispatch('notify', type: 'error', message: 'Access Denied: Admin only.');
                }

                $emp = $response['data'];
                $this->currentPhotoUrl = $emp['photo'] ?? null;
                
                // Fill ALL fields from the API Response
                $this->first_name = $emp['first_name'];
                $this->last_name = $emp['last_name'];
                $this->email = $emp['email'];
                $this->gender = $emp['gender'] ?? '';
                $this->bio = $emp['bio'] ?? '';
                $this->date_of_birth = $emp['date_of_birth'] ?? '';
                // $this->employee_id = $emp['employee_id'] ?? $emp['employee_code']; // Handles naming variations
                $this->joining_date = $emp['joining_date'];
                $this->phone = $emp['phone'] ?? '';
                $this->designation = $emp['designation'];
                $this->department = $emp['department'];
                $this->address = $emp['address'] ?? '';
                
                // Map Banking info from the nested 'banking' key in your Resource
                $this->account_holder_name = $emp['banking']['account_holder_name'] ?? '';
                $this->account_number = $emp['banking']['account_number'] ?? '';
                $this->bank_name = $emp['banking']['bank_name'] ?? '';
                $this->branch_name = $emp['banking']['branch_name'] ?? '';
                $this->routing_number = $emp['banking']['routing_number'] ?? '';
                $this->swift_code = $emp['banking']['swift_code'] ?? '';

                $this->showModal = true;
            }

            // --- SAVE (CREATE OR UPDATE) ---
        // app/Livewire/Dashboard/EmployeeTable.php

        protected function rules()
        {
            return [
                'first_name'    => 'required|string|min:2',
                'last_name'     => 'required|string|min:2',
                'email'         => 'required|email',
                'date_of_birth' => 'nullable|date',
                'gender'        => 'nullable|in:male,female,other',
                'password'      => $this->editId ? 'nullable|min:8' : 'required|min:8',
                // 'employee_id'   => 'required|string',
                'joining_date'  => 'required|date',
                'designation'   => 'required|string',
                'department'    => 'required|string',
                // Banking is optional but must be string if filled
                'account_number' => 'nullable|numeric',
                'phone' => 'nullable|numeric',
                'bank_name'      => 'nullable|string',
            ];
        }

    public function save()
    {
        $this->validate();

        // 1. Build Multipart Payload
        $payload = [
            ['name' => 'first_name',    'contents' => $this->first_name],
            ['name' => 'last_name',     'contents' => $this->last_name],
            ['name' => 'email',         'contents' => $this->email],
            ['name' => 'phone',         'contents' => $this->phone],
            ['name' => 'address',       'contents' => $this->address],
            ['name' => 'gender',        'contents' => $this->gender],
            ['name' => 'bio',           'contents' => $this->bio],
            ['name' => 'date_of_birth', 'contents' => $this->date_of_birth],
            ['name' => 'designation',   'contents' => $this->designation],
            ['name' => 'department',    'contents' => $this->department],
            ['name' => 'joining_date',  'contents' => $this->joining_date],
            // Banking
            ['name' => 'account_holder_name', 'contents' => $this->account_holder_name],
            ['name' => 'account_number',      'contents' => $this->account_number],
            ['name' => 'bank_name',           'contents' => $this->bank_name],
            ['name' => 'branch_name',         'contents' => $this->branch_name],
            ['name' => 'routing_number',      'contents' => $this->routing_number],
            ['name' => 'swift_code',          'contents' => $this->swift_code],
        ];

        if ($this->editId) {
            $payload[] = ['name' => '_method', 'contents' => 'PUT'];
        }

        if ($this->password) {
            $payload[] = ['name' => 'password', 'contents' => $this->password];
        }

        // 2. Handle Photo File
        if ($this->photo) {
            $payload[] = [
                'name'     => 'photo',
                'contents' => fopen($this->photo->getRealPath(), 'r'),
                'filename' => $this->photo->getClientOriginalName(),
            ];
        }

        // 3. API Call using postWithFile
        $response = $this->editId 
            ? $this->api->postWithFile("employees/{$this->editId}", $payload)
            : $this->api->postWithFile("employees", $payload);
        //dd($response);
                // 3. POLICY/AUTHORIZATION ERROR
                if (isset($response['status']) && $response['status'] === 403) {
                    return $this->dispatch('notify', type: 'error', message: 'Access Denied: You do not have permission.');
                }

                // 4. BACKEND VALIDATION ERRORS (Catching unique constraint errors like Email/ID)
                if (isset($response['errors'])) {
                    foreach ($response['errors'] as $field => $messages) {
                        $this->addError($field, $messages[0]);
                    }
                    return;
                }

                $this->dispatch('notify', type: 'success', message: $this->editId ? 'Employee Updated' : 'Employee Added');
                $this->showModal = false;

        }

    // #[On('delete-post')] 
 public function deleteEmployee($uuid)
{
    $response = $this->api->delete("employees/{$uuid}");

    if (isset($response['status']) && $response['status'] === 403) {
        return $this->dispatch('notify', type: 'error', message: 'Unauthorized.');
    }

    $this->dispatch('notify', type: 'success', message: 'Employee Deleted');

    $this->resetPage(); // refresh table
}


    public function render()
    {
        $response = $this->api->get('employees', [
            'search' => $this->search,
            'per_page' => $this->perPage,
            'page' => $this->getPage(),
        ]);
    //dd($response);
        return view('livewire.dashboard.employee-table', [
            'employees' => $response['data'] ?? [],
            'total' => $response['meta']['total'] ?? 0
        ]);
    }
}