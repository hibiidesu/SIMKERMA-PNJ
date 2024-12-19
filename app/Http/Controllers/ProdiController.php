<?php

namespace App\Http\Controllers;

use App\Models\prodi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProdiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getProdiByUnitIDs($units)
    {
        try {
            $unit_ids = explode(',', $units);

            $prodis = Prodi::whereIn('unit_id', $unit_ids)
                ->select('id', 'name')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $prodis
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getProdiByUnitIDs: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    public function index()
    {
        $prodi = prodi::with('unit')->get();

        return view('prodi/index', ['prodi' => $prodi]);
    }
    public function create()
    {
        $unit = Unit::all();
        return view('prodi/add', ['unit' => $unit]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'unit_id' => 'required'
        ]);
        $insert = prodi::create([
            'name' => $request->name,
            'unit_id' => $request->unit_id
        ]);
        if ($insert) {
            return redirect('admin/prodi')->with('success', 'Data Prodi Berhasil ditambahkan');
        } else {
            return redirect('admin/prodi')->with('error', 'Data Prodi gagal ditambahkan');
        }
    }
    public function edit($id) {
        $prodi = prodi::findOrFail($id);
        $unit = Unit::all();
        return view('prodi.edit',['prodi' => $prodi, 'unit' =>$unit]);
    }
    public function update(Request $request) {
        // dd($request);
        $request->validate([
            'name' => 'required|string',
            'unit_id' => 'required'
        ]);


       $update = prodi::where('id',$request->prodi_id)->update([
        'name' => $request->name,
        'unit_id' => $request->unit_id
       ]);

       if($update){
           return redirect('admin/prodi')->with('success', 'Data Diupdate');
        } else {
           return redirect('admin/prodi')->with('error', 'Data  gagal Diupdate');

       }
    }

    public function delete($id) {
        $data = prodi::findOrFail($id);
        $data->delete();
        return redirect('admin/prodi')->with('success', 'Data Prodi Berhasil dihapus');
    }
}
