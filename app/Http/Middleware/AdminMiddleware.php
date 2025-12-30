<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('logins');
        }

        // Your old logic — now works perfectly
        if ($user['type'] === 'user') {
            return redirect()->route('profile2');
        }
// dd($request);
        return $next($request);
    }
}
