<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kriteria_kemitraan;

class KriteriaKemitraanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = kriteria_kemitraan::all();
        return view('kriteria.kemitraan.index',['data' => $data]);
    }

    public function create(){
        return view('kriteria.kemitraan.add');
    }
    public function store(Request $request){
         $request->validate([
            'kriteria_kemitraan' => 'required| string'
        ]);
        $kriteria = kriteria_kemitraan::create([
            'kriteria_kemitraan' => $request->kriteria_kemitraan
        ]);
        if($kriteria){
            return redirect('admin/kriteria/kemitraan')->with('success', 'Data Mitra Berhasil ditambahkan');

        } else {
            return redirect('admin/kriteria/kemitraan')->with('error', 'Data Mitra gagal ditambahkan');
        }

    }
    public function edit($id){
        $data = kriteria_kemitraan::findOrFail($id);
        return view('kriteria.kemitraan.edit',compact('data'));

    }
    public function update(Request $request){
        $request->validate([
            'kriteria_kemitraan' => 'required|string',
        ]);

        $update = kriteria_kemitraan::findOrFail($request->id)->update([
            'kriteria_kemitraan' => $request->kriteria_kemitraan
        ]);
        if($update){
            return redirect('/admin/kriteria/kemitraan')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/admin/kriteria/kemitraan')->with('error', 'Data gagal diupdate');
        }

    }
    public function delete($id){
        $find = kriteria_kemitraan::findOrFail($id);
        $delete = $find->delete();
        if($delete){
            return redirect('/admin/kriteria/kemitraan')->with('success', 'Data di hapus');
        } else {
            return redirect('/admin/kriteria/kemitraan')->with('error', 'gagal menghapus data');
        }
    }
}
