<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class SSOController extends Controller
{
    // tinggal di rubah menggunakan SSO PNJ
    public function loginSSO()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackSSO()
    {
        $user = Socialite::driver('google')->user();

        if ($user) {
            $data = $user->user;
            $userDb = User::where("email", $data['email'])->first();
            if ($userDb) {
                Auth::login($userDb);
                return redirect()->route('checkrole');
            } else {
                return view("auth.sso", [
                    "data" => $data,
                ]);
            }
        } else {
            return redirect("/login");
        }
    }
    public function registerSSO(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'password' => 'required|min:8',
                'username' => 'required'
            ]
        );
        if (strlen($request->password) < 8) {
            return redirect()->route("login")->with('error', 'Password minimal 8 karakter, silahkan coba lagi');
        }
        if ($request->password != $request->repassword) {
            return redirect()->route("login")->with('error', 'Password tidak sama, silahkan coba lagi');
        }

        $user = User::forceCreate([
            "name" => $request->name,
            "email" => $request->email,
            "username"=> $request->username,
            'password' => Hash::make($request->password),
            'role_id' => 4,
            'email_verified_at' => Carbon::now(),
            'status' => 1,
        ]);
        if ($user) {
            Auth::login($user);
            return redirect()->route("checkrole");
        } else {
            return redirect()->route("login")->with('error', 'Gagal membuat user, silahkan coba lagi');
        }
    }
}
