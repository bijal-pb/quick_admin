<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;



class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect("/login");
        }
        if ($user) {
            if ($user->hasRole('admin')) {
                $user->tokens()->delete();
                return redirect("/");
                // abort(401, "You don't have permission to access this area");
            }
        }
        return $next($request);
    }
}
