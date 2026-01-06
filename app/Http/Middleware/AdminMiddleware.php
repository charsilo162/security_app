<?php

namespace App\Http\Middleware; 

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
   public function handle($request, Closure $next) {
            $user = Session::get('user');
            if (!$user || $user['type'] !== 'admin') {
                return redirect()->route('logins');
            }
            return $next($request);
        }
}
