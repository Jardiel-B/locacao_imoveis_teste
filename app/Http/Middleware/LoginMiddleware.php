<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginMiddleware{
    public function handle(Request $request, Closure $next)
    {   
        if (!session('email')) 
            return redirect()->route('login')->with('erro','Login expirado');

        return $next($request);
    }
}