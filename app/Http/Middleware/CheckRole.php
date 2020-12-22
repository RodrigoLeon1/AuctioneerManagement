<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{

    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)) {
            Auth::logout();
            return redirect()
                ->route('login')
                ->with('error-login', 'No posee los permisos necesarios para ingresar al sistema.');
        }
        return $next($request);
    }
}
