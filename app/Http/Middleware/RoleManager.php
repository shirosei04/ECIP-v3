<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $type)
    {
        if (Auth::user() &&  Auth::user()->role == $type) {
            return $next($request);
        }
        else{
            return redirect('/dashboard')->with('message', 'You are not allowed to access deez nuts!');
        }
        // return redirect(RouteServiceProvider::HOME);
    }
}
