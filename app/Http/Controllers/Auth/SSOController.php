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
        return Socialite::driver('pnj')->redirect();
    }

    public function callbackSSO()
    {
        try {
            $socialiteUser = Socialite::driver('pnj')->user();

            if ($socialiteUser) {
                $email = $socialiteUser->getEmail();
                $userDb = User::where("email", $email)->first();

                if ($userDb) {
                    Auth::login($userDb);
                    return redirect()->route('checkrole');
                } else {
                    return view("auth.sso", [
                        "data" => $socialiteUser,
                    ]);
                    return redirect()->route('login')->with('error', 'Email tidak terdaftar di database, silahkan menghubungi admin untuk mendaftarkan akun anda.');
                }
            } else {
                return redirect()->route('login')->with('error', 'Tidak dapat mendapatkan data user Google.');
            }
        } catch (\Exception $e) {
            \Log::error('SSO Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred during SSO login. Please try again.\n'. $e->getMessage());
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
