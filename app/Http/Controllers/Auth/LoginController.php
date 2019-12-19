<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/adminhome';

    // protected function redirectTo()
    // {
    //     if(Auth::guard($guard)->check()){
    //         // dd(Auth::user()->role);
    //         if (Auth::user()->role == 'coordinator') {
    //             return redirect('/adminhome');
    //         } elseif (Auth::user()->role == 'staff') {
    //             return redirect('/adminhome');
    //         } elseif (Auth::user()->role == 'manager') {
    //             return redirect('/adminhome');
    //         } elseif (Auth::user()->role == 'admin') {
    //             return redirect('/adminhome');
    //         } elseif (Auth::user()->role == 'student') {
    //             return redirect('ideapanel.index');
    //         } 
    //     }
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
