<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPasswordSet
{

    public function handle(Request $request, Closure $next)
    {
        if (
            auth()->check() &&
            auth()->user()->password == null &&
            !$request->is('password') &&
            !$request->password
        ) {
            return redirect()->route('usuarios.setpassword');
        }
        return $next($request);
    }
}
