<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{
    public function logout()
    {
        \Log::alert('LOGOUT SUCCESS — USER LOGGED OUT: ' . session('user.name'));

        try {
            app(\App\Services\ApiService::class)->post('logout');
        } catch (\Exception $e) {
            // Still log out frontend even if API fails
        }

        Session::flush();
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}