<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() == false){
            return redirect()->route('auth.getLoginForm');
        }
        return $next($request);
    }
}
