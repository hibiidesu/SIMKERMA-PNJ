<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kriteria_mitra as KritMit;

class KriteriaMitraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = KritMit::all();
        return view('kriteria.mitra.index',['data' => $data]);
    }

    public function create(){
        return view('kriteria.mitra.add');
    }
    public function store(Request $request){
         $request->validate([
            'kriteria_mitra' => 'required| string'
        ]);
        $kriteria = KritMit::create([
            'kriteria_mitra' => $request->kriteria_mitra
        ]);
        if($kriteria){
            return redirect('admin/kriteria/mitra')->with('success', 'Data Mitra Berhasil ditambahkan');

        } else {
            return redirect('admin/kriteria/mitra')->with('error', 'Data Mitra gagal ditambahkan');
        }

    }
    public function edit($id){
        $data = KritMit::findOrFail($id);
        return view('kriteria.mitra.edit',compact('data'));

    }
    public function update(Request $request){
        $request->validate([
            'kriteria_mitra' => 'required|string',
        ]);

        $update = KritMit::findOrFail($request->id)->update([
            'kriteria_mitra' => $request->kriteria_mitra
        ]);
        if($update){
            return redirect('/admin/kriteria/mitra')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/admin/kriteria/mitra')->with('error', 'Data gagal diupdate');
        }

    }
    public function delete($id){
        $find = KritMit::findOrFail($id);
        try {
            $find->forceDelete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus permanen']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data gagal dihapus, karena: '.$e->getMessage()], 500);
        }
    }
}
