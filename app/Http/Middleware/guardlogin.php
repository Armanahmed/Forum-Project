<?php

namespace App\Http\Middleware;

use Closure;
// use \App\Http\Middleware\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\user;

class guardlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$action)
    {
        $id = Auth::id();
        $user = User::find($id);
        
        if( $user->role == 'student' ){
            return redirect('ideapanel');
        } elseif( in_array($user->role, $action) ) {
            return $next($request);
        }else {
            return redirect('/adminhome');
        }        
    }
}
