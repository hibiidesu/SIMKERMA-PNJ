<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kerjasama;
use App\Models\implementationAgreement;

class ImplementationAgreementController extends Controller
{
    public function index() {
        return view('IAView.index');
    }
    public function create(){

        return view('IAView.add', [
            'data' => Kerjasama::all()
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'nama_mitra' => 'required',
            'dokumen_agreement' => 'required|mimes:pdf,docx,doc',
        ]);
        $file = $request->file('dokumen_agreement');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/IA', $fileName);
         $ia = implementationAgreement::create([
            'nama_mitra' => $request->nama_mitra,
            'dokumen_agreement' => $fileName,
        ]);
        if($ia){
            return redirect()->route('IAView.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('IAView.index')->with('error', 'Data gagal Ditambahkan');
        }

    }
    public function destroy($id){

    }
}
