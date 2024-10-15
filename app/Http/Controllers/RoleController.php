<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkRole()
    {
        if(Auth::user()->status == 1){
            if (Auth::User()->role->role_name == 'admin') {
                return redirect(route('adminHome'));
            } elseif (Auth::User()->role->role_name == 'pemimpin') {
                return redirect(route('PemimpinHome'));
            }
        }else{
            Auth::logout();
            return redirect('/login')->with('info','Akun anda telah di nonaktifkan');
        }
    }
}
