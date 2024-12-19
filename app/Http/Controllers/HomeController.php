<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view()
    {
        // dd(Auth::User()->role->role_name);
        if (Auth::User()->role->role_name == 'admin') {
            return view('home');
        } elseif (Auth::User()->role->role_name == 'pemimpin') {
            return view('home');
        } elseif (Auth::User()->role->role_name == 'pic') {
            return view('home');
        } elseif (Auth::User()->role->role_name == 'legal') {
            return view('home');
        } elseif (Auth::User()->role->role_name == 'direktur') {
            return view('home');
        }

    }
}
