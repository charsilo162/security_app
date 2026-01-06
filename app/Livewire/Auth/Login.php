<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $isLoading = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
public function mount()
{
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


   public function login()
        {
            $this->validate();
            $this->isLoading = true;

            try {
                $response = (new ApiService())->post('login', [
                    'email' => $this->email,
                    'password' => $this->password,
                ]);

                if (isset($response['token'])) {
                    Session::put('api_token', $response['token']);
                    Session::put('user', $response['user']);

                    $user = $response['user'];

                    // Role-Based Redirect Logic
                   return match($user['type']) {
                        'admin'    => redirect()->route('admin.index'),      
                        'client'   => redirect()->route('client.dashboard'),  
                        'employee' => redirect()->route('employee.roster'),  
                        default    => redirect()->route('logins'),
                    };
                } 
                
                $this->addError('email', 'Invalid credentials');

            } catch (\Exception $e) {
                //   dd(
                //         $e->getMessage(),
                //         $e->getFile(),
                //         $e->getLine(),
                //         $e->getTraceAsString()
                //     );
                $this->addError('email', 'Connection error. Please try again.');
            }

            $this->isLoading = false;
        }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth', [
                'title' => 'Login'
            ]);
    }
}
