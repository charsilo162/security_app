<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Services\ApiService;


class Logout extends Component
{
    public function logout()
    {
       
        $userName = session('user.first_name', 'User');
        // \Log::info("User Logout Initiated: " . $userName);

        try {
            // Tell the API to revoke the current token
            app(ApiService::class)->post('logout');
        } catch (\Exception $e) {
            // Silently fail if API is unreachable
        }

        // Wipe EVERYTHING from the Laravel session
        Session::flush();

        // Redirect to the login page with a success message
        return redirect()->route('logins')->with('status', 'Successfully logged out.');
    }

    public function render()
    {
        // This component can just be a button or an empty view
        return <<<'HTML'
            <button wire:click="logout" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 w-full text-left text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 group">
                <i class="fas fa-sign-out-alt w-5 group-hover:-translate-x-1 transition-transform"></i>
                <span class="font-medium">Logout</span>
            </button>
        HTML;
    }
}