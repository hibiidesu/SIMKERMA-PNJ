<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user.index', [
            'data' => User::orderBy('id', 'desc')->get()
        ]);
    }

    public function edit(Request $request, $id)
    {
        if ($request->segment(2) == 'my-profile' && Auth::user()->id != $id) {
            return redirect('/' . $request->segment(1) . '/dashboard')->with('success', 'User Berhasil diubah');
        }
        return view('user/edit', [
            'role' => Role::all(),
            'data' => User::findOrFail($id),
        ]);
    }

    public function create()
    {
        return view('user/add', [
            'role' => Role::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users,username|min:5',
                'email' => 'required|unique:users,email|email',
                'password' => 'required|min:8',
                're_password' => 'required|same:password',
                'role_id' => 'required',

            ]
        );
        $insert = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => 1,
        ]);
        if ($insert) {
            return redirect('/admin/user')->with('success', 'User Berhasil ditambahkan');
        } else {
            return redirect('/admin/user')->with('error', 'User Gagal ditambahkan');
        }
        dd($request->input(), $insert);
    }

    public function profileUpdate(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',

            ]
        );
        $update = 0;
        if ($request->password) {
            $request->validate(
                [
                    'password' => 'required|min:8',
                    're_password' => 'required|same:password',
                ]
            );
            $update = User::findOrFail(Auth::user()->id)->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $update = User::findOrFail(Auth::user()->id)->update([
                'name' => $request->name,
            ]);
        }
        if ($update) {
            return redirect('/' . $request->segment(1) . '/my-profile/' . Auth::user()->id)->with('success', 'Profile Berhasil diubah');
        } else {
            return redirect('/' . $request->segment(1) . '/my-profile/' . Auth::user()->id)->with('error', 'Profile Gagal diubah');
        }
        dd($request->input(), $update);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'id' => 'required',
                'name' => 'required',
                'username' => 'required|min:5',
                'email' => 'required|email',
                'role_id' => 'required',

            ]
        );
        $update = 0;
        if ($request->password) {
            $request->validate(
                [
                    'password' => 'required|min:8',
                    're_password' => 'required|same:password',
                ]
            );
            $update = User::findOrFail($request->id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);
        } else {
            $update = User::findOrFail($request->id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role_id' => $request->role_id,
            ]);
        }
        if ($update) {
            return redirect('/admin/user')->with('success', 'User Berhasil diubah');
        } else {
            return redirect('/admin/user')->with('error', 'User Gagal diubah');
        }
        dd($request->input(), $update);
    }

    public function deactivate(Request $request, $id)
    {
        $update = User::findOrFail($id)->update([
            'status' => 0,
        ]);
        if ($update) {
            return redirect('/admin/user')->with('success', 'User Berhasil dinonaktifkan');
        } else {
            return redirect('/admin/user')->with('error', 'User Gagal dinonaktifkan');
        }
        dd($id);
    }

    public function activate(Request $request, $id)
    {
        $update = User::findOrFail($id)->update([
            'status' => 1,
        ]);
        if ($update) {
            return redirect('/admin/user')->with('success', 'User Berhasil diaktifkan');
        } else {
            return redirect('/admin/user')->with('error', 'User Gagal diaktifkan');
        }
        dd($id);
    }
}
