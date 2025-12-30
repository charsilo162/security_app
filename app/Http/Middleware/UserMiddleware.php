<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('logins');
        }

        if (($user['type']) !== 'user') {
            return redirect()->route('my.course');
        }

        return $next($request);
    }
}