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
        // Prevent login page if already logged in
        if (Session::has('api_token') && Session::has('user')) {
            return redirect()->route('dashboard.index'); // dashboard or category page
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

                // Save token and user in session
                Session::put('api_token', $response['token']);
                Session::put('user', $response['user']);

                return redirect()->route('dashboard.index'); 
            } 
            else {
                $this->addError('email', 'Invalid credentials');
            }

        } catch (\Illuminate\Http\Client\RequestException $e) {

            $message = $e->response->json('message') ?? 'Invalid credentials';
            $this->addError('email', $message);

        } catch (\Exception $e) {

            $this->addError('email', 'Something went wrong. Try again.');
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
