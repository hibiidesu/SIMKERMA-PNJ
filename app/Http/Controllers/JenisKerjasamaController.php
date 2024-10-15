<?php

namespace App\Http\Controllers;

use App\Models\Jenis_kerjasama;
use Illuminate\Http\Request;

class JenisKerjasamaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('jenis-kerjasama/index', [
            'data' => Jenis_kerjasama::orderBy('id', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('jenis-kerjasama/add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kerjasama' => 'required|unique:jenis_kerjasamas,jenis_kerjasama',
        ]);
        $insert = Jenis_kerjasama::create([
            'jenis_kerjasama' => $request->jenis_kerjasama,
        ]);
        if($insert) {
            return redirect('/admin/jenis-kerjasama')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect('/admin/jenis-kerjasama')->with('error', 'Data gagal ditambahkan');
        }
    }

    public function show(Jenis_kerjasama $Jenis_kerjasama)
    {
        //
    }

    public function edit(Jenis_kerjasama $Jenis_kerjasama, $id)
    {
        return view('jenis-kerjasama/edit', [
            'data' => Jenis_kerjasama::findOrFail($id),
        ]);
    }

    public function update(Request $request, Jenis_kerjasama $Jenis_kerjasama)
    {
        $request->validate([
            'id' => 'required',
            'jenis_kerjasama' => 'required|unique:jenis_kerjasamas,jenis_kerjasama',
        ]);
        $update = Jenis_kerjasama::findOrFail($request->id)->update([
            'jenis_kerjasama' => $request->jenis_kerjasama,
        ]);
        if ($update) {
            return redirect('/admin/jenis-kerjasama')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/admin/jenis-kerjasama')->with('error', 'Data gagal diupdate');
        }
        dd($request->input());
    }

}
