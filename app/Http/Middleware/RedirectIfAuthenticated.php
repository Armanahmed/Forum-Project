<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home');
        // }

        // $user = Auth::user();
        // dd($request->name);

        if(Auth::guard($guard)->check()){
            // dd(Auth::user()->role);
            if (Auth::user()->role == 'coordinator') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'staff') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'manager') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('/adminhome');
            } elseif (Auth::user()->role == 'student') {
                return redirect('/ideapanel');
            } 
        }

        return $next($request);
    }
}
