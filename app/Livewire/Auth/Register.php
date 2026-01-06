<?php
namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ApiService;

class Register extends Component
{
    use WithFileUploads;

    // Toggle between 'employee' and 'client'
    public string $role = 'client'; 

    // Common Fields
    public $first_name, $last_name, $email, $password, $phone, $address, $photo;

    // Client Specific
    public $company_name, $industry;

    // Employee Specific
    public $designation, $department;

    protected ApiService $api;
    public function boot(ApiService $api) { $this->api = $api; }

    public function setRole($role)
    {
        $this->role = $role;
        $this->resetValidation();
    }

    protected function rules()
    {
        $common = [
            'first_name' => 'required|string|min:2',
            'email'      => 'required|email',
            'password'   => 'required|min:8',
            'phone'      => 'required',
        ];

        if ($this->role === 'client') {
            return array_merge($common, ['company_name' => 'required|string']);
        }

        return array_merge($common, [
            'designation' => 'required',
            'department'  => 'required'
        ]);
    }

    public function register()
    {
        $this->validate();

        $payload = [
            ['name' => 'first_name', 'contents' => $this->first_name],
            ['name' => 'last_name',  'contents' => $this->last_name],
            ['name' => 'email',      'contents' => $this->email],
            ['name' => 'password',   'contents' => $this->password],
            ['name' => 'phone',      'contents' => $this->phone],
            ['name' => 'role',       'contents' => $this->role], // Tell API the role
        ];

        // Add Role-Specific fields
        if ($this->role === 'client') {
            $payload[] = ['name' => 'company_name', 'contents' => $this->company_name];
        } else {
            $payload[] = ['name' => 'designation', 'contents' => $this->designation];
        }

        // Handle Photo
        if ($this->photo) {
            $payload[] = [
                'name'     => 'photo',
                'contents' => fopen($this->photo->getRealPath(), 'r'),
                'filename' => $this->photo->getClientOriginalName(),
            ];
        }

        // Endpoint could be a public 'register' endpoint or reuse your existing ones
        $endpoint = ($this->role === 'client') ? "register/client" : "register/employee";
        
        $response = $this->api->postWithFile($endpoint, $payload);

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function render()
    {
       // return view('livewire.auth.register');
        return view('livewire.auth.register')
            ->layout('layouts.auth');
    }
}