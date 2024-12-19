<?php

namespace App\Http\Controllers;

use App\Models\implementationAgreement;
use App\Models\Jenis_kerjasama;
use Illuminate\Http\Request;
use App\Models\Kerjasama;
use App\Models\pks;
use Illuminate\Support\Facades\Storage;

class ImplementationAgreementController extends Controller
{
    public function index() {
        $data = implementationAgreement::all();
        return view('IAView.index', compact('data'));
    }
    public function create(){
        return view('IAView.add', [
            'data' => Kerjasama::all()
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'nama_mitra' => 'required',
            'dokumen_agreement' => 'required|mimes:pdf',
        ]);
        $file = $request->file('dokumen_agreement');
        $fileName = time() . '.'. $file->getClientOriginalName();
        $move = Storage::disk('dokumen_agreement')->put($fileName, file_get_contents($file));

        if($move){
            implementationAgreement::create([
            'nama_mitra' => $request->nama_mitra,
            'dokumen_agreement' => $fileName,
           ]);

            return redirect('/admin/agreement/')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect('/admin/agreement/')->with('error', 'Data gagal Ditambahkan');
        }
    }
    public function show($id) {
        $ia = implementationAgreement::find($id);

        if (!$ia) {
            return redirect()->back()->with('error', 'Implementation Agreement not found');
        }
        $dataKerjasama = Kerjasama::where('mitra', $ia->nama_mitra)->with('pks')
        ->get();

        return view('IAView.detail', compact('ia', 'dataKerjasama'));
    }

        public function edit($id)
    {
        $ia = implementationAgreement::findOrFail($id);
        $kerjasamas = Kerjasama::all();
        return view('IAView.edit', compact('ia', 'kerjasamas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:implementation_agreements,id',
            'nama_mitra' => 'required',
            'dokumen_agreement' => 'nullable|mimes:pdf',
        ]);

        $ia = implementationAgreement::findOrFail($request->id);
        $ia->nama_mitra = $request->nama_mitra;

        if ($request->hasFile('dokumen_agreement')) {
            // Delete old file
            if ($ia->dokumen_agreement) {
                Storage::disk('dokumen_agreement')->delete($ia->dokumen_agreement);
            }

            // Upload new file
            $file = $request->file('dokumen_agreement');
            $fileName = time() . '.' . $file->getClientOriginalName();
            Storage::disk('dokumen_agreement')->put($fileName, file_get_contents($file));
            $ia->dokumen_agreement = $fileName;
        }

        if ($ia->save()) {
            return redirect('/admin/agreement')->with('success', 'Data Berhasil Diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        $ia = implementationAgreement::findOrFail($id);

        // Delete the associated file
        if ($ia->dokumen_agreement) {
            Storage::disk('dokumen_agreement')->delete($ia->dokumen_agreement);
        }

        $ia->delete();

        return redirect('/admin/agreement')->with('success', 'Data Berhasil Dihapus');
    }
}
