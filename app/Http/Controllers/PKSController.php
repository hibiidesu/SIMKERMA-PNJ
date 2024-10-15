<?php

namespace App\Http\Controllers;

use App\Models\pks;
use Illuminate\Http\Request;

class PKSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perjanjian/index', [
            'data' => pks::orderBy('id', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('perjanjian/add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pks' => 'required|unique:pks,pks',
        ]);
        $insert = pks::create([
            'pks' => $request->pks,
        ]);
        if ($insert) {
            return redirect('/admin/perjanjian-kerjasama')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect('/admin/perjanjian-kerjasama')->with('success', 'Data berhasil ditambahkan');
        }
        dd($request->input());
    }

    public function show(pks $pks)
    {
        //
    }

    public function edit(pks $pks, $id)
    {
        return view('perjanjian/edit', [
            'data' => pks::findOrFail($id),
        ]);
    }

    public function update(Request $request, pks $pks)
    {
        $request->validate([
            'id' => 'required',
            'pks' => 'required|unique:pks,pks',
        ]);
        $update = pks::findOrFail($request->id)->update([
            'pks' => $request->pks,
        ]);
        if ($update) {
            return redirect('/admin/perjanjian-kerjasama')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/admin/perjanjian-kerjasama')->with('error', 'Data gagal diupdate');
        }
        dd($request->input());
    }

    public function destroy(pks $pks, $id)
    {
        dd($id);
    }
}
