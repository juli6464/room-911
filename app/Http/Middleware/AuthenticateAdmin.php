<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin_room_911') {
            return redirect()->route('login')->withErrors(['error' => 'Acceso denegado']);
        }

        return $next($request);
    }
}
