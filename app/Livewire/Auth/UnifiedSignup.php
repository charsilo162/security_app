<?php
namespace App\Livewire\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class UnifiedSignup extends Component
{
    use WithFileUploads;

    public string $role = 'employee'; 

    // Common Fields
    public $first_name, $last_name, $email, $phone, $password, $address, $photo;

    // Employee Specific
    public $designation, $department, $joining_date, $gender, $bio, $date_of_birth;
    public $account_holder_name, $account_number, $bank_name, $branch_name, $routing_number, $swift_code;

    // Client Specific
    public $company_name, $industry, $registration_number;

    protected ApiService $api;
    public function boot(ApiService $api) { $this->api = $api; }

  

   public function mount()
{
    $urlRole = request()->query('role');

    if ($urlRole && in_array($urlRole, ['employee', 'client'])) {
        $this->role = $urlRole;
    }

    // 3. Your existing Login Session check
    if (Session::has('api_token') && Session::has('user')) {
        $user = Session::get('user');

        return match ($user['type']) {
            'admin'    => redirect()->route('admin.index'),
            'client'   => redirect()->route('client.dashboard'),
            'employee' => redirect()->route('employee.roster'),
            default    => redirect()->route('home'),
        };
    }
}
    // RENAMED: from getRules to validationRules to avoid Livewire conflict
  private function validationRules()
{
    $rules = [
        // Common fields
        'first_name' => 'required|string|max:20',
        'last_name'  => 'required|string|max:20',
        'email'      => 'required|email',
        'phone'      => 'nullable|string|max:20',
        'password'   => 'required|string|min:8',
        'address'    => 'nullable|string|max:100',
        'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];

    if ($this->role === 'employee') {

        $rules += [
            // Employee profile
            'designation'     => 'required|string|max:100',
            'department'      => 'required|string|max:100',
            'gender'          => 'nullable|in:male,female,other',
            'bio'             => 'nullable|string|max:500',
            'date_of_birth'   => 'required|date|before_or_equal:today',
            'joining_date'    => 'required|date|after_or_equal:date_of_birth',

            // Bank details
            'account_holder_name' => 'required|string|max:100',
            'account_number'      => 'required|string|min:6|max:20',
            'bank_name'           => 'required|string|max:30',
            'branch_name'         => 'nullable|string|max:30',
            'routing_number'      => 'nullable|string|max:30',
            'swift_code'          => 'nullable|string|max:20',
        ];

    } else {

        $rules += [
            // Client profile
            'company_name'        => 'required|string|max:150',
            'industry'            => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
        ];
    }

    return $rules;
}

    public function setRole($role)
{
    $this->role = $role;
    
    
    $this->resetValidation(); 
    
    // Optional: Reset specific fields if you want a clean slate
    if($role === 'client') {
        $this->joining_date = null;
    }
}
    public function signup()
    {
        
        $this->validate($this->validationRules());
       // dd($this->validate($this->validationRules()));
        // 1. Build Payload (sending 'role' so backend knows which logic to use)
        $payload = [
            ['name' => 'role',       'contents' => $this->role],
            ['name' => 'first_name', 'contents' => $this->first_name],
            ['name' => 'last_name',  'contents' => $this->last_name],
            ['name' => 'email',      'contents' => $this->email],
            ['name' => 'phone',      'contents' => $this->phone],
            ['name' => 'password',   'contents' => $this->password],
            ['name' => 'address',    'contents' => $this->address],
        ];

        if ($this->role === 'employee') {
            $this->appendEmployeeData($payload);
        } else {
            $this->appendClientData($payload);
        }

        if ($this->photo) {
            $payload[] = [
                'name'     => 'photo',
                'contents' => fopen($this->photo->getRealPath(), 'r'),
                'filename' => $this->photo->getClientOriginalName(),
            ];
        }
// dd('yere');
        // 2. Call the Register API
        $response = $this->api->postWithFile('register', $payload);
// dd($response);
        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        // 3. SET SESSION (Exactly like your login logic)
               if (isset($response['access_token'])) {

    // Inject profile_uuid into the user array
    $user = $response['user'];
    $user['profile_uuid'] = $response['profile_uuid'];
//dd($user);
    // Now save to session
    Session::put('api_token', $response['access_token']);
    Session::put('user', $user);

    // Continue as normal
    return match($user['type']) {
        'admin'    => redirect()->route('admin.clients'),      
        'client'   => redirect()->route('client.dashboard'),  
        'employee' => redirect()->route('employee.roster'),  
        default    => redirect()->route('home'),
    };
}

        $this->addError('email', 'Account created but could not log you in.');
    }

  // ... inside class UnifiedSignup extends Component

private function appendEmployeeData(&$payload) {
    $payload[] = ['name' => 'address', 'contents' => $this->address];
    $payload[] = ['name' => 'gender', 'contents' => $this->gender];
    $payload[] = ['name' => 'bio', 'contents' => $this->bio];
    $payload[] = ['name' => 'date_of_birth', 'contents' => $this->date_of_birth];
    $payload[] = ['name' => 'designation', 'contents' => $this->designation];
    $payload[] = ['name' => 'department', 'contents' => $this->department];
    $payload[] = ['name' => 'joining_date', 'contents' => $this->joining_date];
    // Banking
    $payload[] = ['name' => 'account_holder_name', 'contents' => $this->account_holder_name];
    $payload[] = ['name' => 'account_number', 'contents' => $this->account_number];
    $payload[] = ['name' => 'bank_name', 'contents' => $this->bank_name];
    $payload[] = ['name' => 'branch_name', 'contents' => $this->branch_name];
    $payload[] = ['name' => 'routing_number', 'contents' => $this->routing_number];
    $payload[] = ['name' => 'swift_code', 'contents' => $this->swift_code];
}

private function appendClientData(&$payload) {
    $payload[] = ['name' => 'address', 'contents' => $this->address];
    $payload[] = ['name' => 'company_name', 'contents' => $this->company_name];
    $payload[] = ['name' => 'industry', 'contents' => $this->industry];
    $payload[] = ['name' => 'type', 'contents' => 'client'];
}
    public function render()
    {
        return view('livewire.auth.unified-signup')->layout('layouts.auth');
    }
}