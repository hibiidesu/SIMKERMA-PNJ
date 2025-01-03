<?php

namespace App\Http\Controllers;

use App\Models\bidangKerjasama;
use Illuminate\Http\Request;

class BidangKerjasamaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bidang-kerjasama/index', [
            'data' => bidangKerjasama::orderBy('id', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('bidang-kerjasama/add');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama_bidang' => 'required',
        ]);
        $insert = bidangKerjasama::create([
            'nama_bidang' => $request->nama_bidang,
        ]);
        if ($insert) {
            return redirect('/admin/bidang-kerjasama')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect('/admin/bidang-kerjasama')->with('error', 'Data gagal ditambahkan');
        }
    }

    public function edit(bidangKerjasama $bk, $id)
    {
        return view('bidang-kerjasama/edit', [
            'data' => bidangKerjasama::findOrFail($id),
        ]);
    }

    public function update(Request $request, bidangKerjasama $bk)
    {
        // dd($request);
        $request->validate([
            'id' => 'required',
            'nama_bidang' => 'required',
        ]);
        $update = bidangKerjasama::findOrFail($request->id)->update([
            'nama_bidang' => $request->nama_bidang,
        ]);
        if ($update) {
            return redirect('/admin/bidang-kerjasama')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/admin/bidang-kerjasama')->with('error', 'Data gagal diupdate');
        }
        dd($request->input());
    }
}
