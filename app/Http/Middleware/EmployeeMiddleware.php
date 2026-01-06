<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class EmployeeMiddleware
{
  public function handle($request, Closure $next) {
    $user = Session::get('user');
    if (!$user || $user['type'] !== 'employee') {
        return redirect()->route('logins');
    }
    return $next($request);
}
}