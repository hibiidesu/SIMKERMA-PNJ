<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Jenis_kerjasama;
use App\Models\Kerjasama;
use App\Models\pks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Repository;
use App\Models\Unit;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KerjasamaExport;
use Illuminate\Support\Facades\Validator;


use App\Models\kriteria_kemitraan;
use App\Models\kriteria_mitra;
use App\Models\log_persetujuan;
use App\Models\prodi;

class KerjasamaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unit = [];
        $prodi = [];
        $perjanjian = [];
        $kriteria_kemitraan = [];
        $kriteria_mitra = [];
        $prodi = [];
        foreach (Kriteria_kemitraan::all() as $item) {
            $kriteria_kemitraan[$item->id] = $item->kriteria_kemitraan;
        }
        foreach (Kriteria_mitra::all() as $item) {
            $kriteria_mitra[$item->id] = $item->kriteria_mitra;
        }
        foreach (Unit::all() as $item) {
            $unit[$item->id] = $item->name;
        }
        foreach (pks::all() as $item) {
            $perjanjian[$item->id] = $item->pks;
        }
        foreach (prodi::all() as $item) {
            $prodi[$item->id] = $item->name;
        }

        foreach (prodi::all() as $item) {
            $prodi[$item->id] = $item->name;
        }

        $data = Kerjasama::orderBy('id', 'desc')->where('step', 7);
        if ($request->has('type') && $request->type != 'all') {
            $data = $data->where('jenis_kerjasama_id', ($request->type - 1));
        }
        if ($request->has('k_mitra') && $request->k_mitra != 'all') {
            if (is_array($request->k_mitra)) {
                $data = $data->where(function($query) use ($request) {
                    foreach ($request->k_mitra as $mitraId) {
                        $query->orWhereRaw("? = ANY (string_to_array(kriteria_mitra_id, ','))", [$mitraId]);
                    }
                });
            } else {
                $data = $data->whereRaw("? = ANY (string_to_array(kriteria_mitra_id, ','))", [$request->k_mitra]);
            }
        }

        if ($request->has('k_kemitraan') && $request->k_kemitraan != 'all') {
            if (is_array($request->k_kemitraan)) {
                $data = $data->where(function($query) use ($request) {
                    foreach ($request->k_kemitraan as $kemitraanId) {
                        $query->orWhereRaw("? = ANY (string_to_array(kriteria_kemitraan_id, ','))", [$kemitraanId]);
                    }
                });
            } else {
                $data = $data->whereRaw("? = ANY (string_to_array(kriteria_kemitraan_id, ','))", [$request->k_kemitraan]);
            }
        }



        if ($request->has('sifat') && $request->sifat != 'all') {
            $data = $data->where('sifat', $request->sifat);
        }

        if ($request->has('date') && $request->date != '1') {
            if ($request->date == '2') {
                $data = $data->whereDate('tanggal_selesai', '>=', Carbon::now());
            } else if ($request->date == '3') {
                $data = $data->whereDate('tanggal_selesai', '>=', Carbon::now());
                $data = $data->whereMonth('tanggal_selesai', '>=', Carbon::now()->month);
                $data = $data->whereMonth('tanggal_selesai', '<=', Carbon::now()->month + 3);
                $data = $data->whereYear('tanggal_selesai', date('Y'));
            } else if ($request->date == '4') {
                $data = $data->whereDate('tanggal_selesai', '<', Carbon::now());
            }
        }
        // TODO : Membuat Data Kerjasama menjadi Expire atau auto tertolak sehingga PIC harus Mengajukan Ulang

        return view('kerjasama/index', [
            'unit' => $unit,
            'prodi' => $prodi,
            'kriteria_mitra_filter' => kriteria_mitra::all(),
            'kriteria_kemitraan_filter' => kriteria_kemitraan::all(),
            'kriteria_kemitraan' => $kriteria_kemitraan,
            'kriteria_mitra' => $kriteria_mitra,
            'jenisKerjasama' => Jenis_kerjasama::all(),
            'perjanjian' => $perjanjian,
            'data' => $data->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kerjasama  $kerjasama
     * @return \Illuminate\Http\Response
     */
    public function show(Kerjasama $kerjasama, $id)
    {
        $data = Kerjasama::findOrFail($id);
        $perjanjian = pks::whereIn('id', explode(',', $data->pks))->get();
        $unit = "";
        $prodi = "";
        if ($data->jurusan != '') {
            $unit = Unit::whereIn('id', explode(',', $data->jurusan))->get();
        }
        if ($data->prodi != '') {
            $prodi = prodi::whereIn('id', explode(',', $data->prodi))->get();
        }
        return view('kerjasama/detail', [
            'unit' => $unit,
            'prodi' => $prodi,
            'perjanjian' => $perjanjian,
            'data' => $data,
        ]);
    }
    public function showRepo(Kerjasama $kerjasama, $id)
    {
        $data = Repository::findOrFail($id);
        $perjanjian = pks::whereIn('id', explode(',', $data->pks))->get();
        $unit = "";
        $prodi= "";
        if ($data->jurusan != '') {
            $unit = Unit::whereIn('id', explode(',', $data->jurusan))->get();
        }
        if ($data->prodi != '') {
            $prodi = prodi::whereIn('id', explode(',', $data->prodi))->get();
        }
        return view('kerjasama/repo', [
            'unit' => $unit,
            'prodi' => $prodi,
            'perjanjian' => $perjanjian,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kerjasama  $kerjasama
     * @return \Illuminate\Http\Response
     */
    public function edit(Kerjasama $kerjasama, $id)
    {
        return view('kerjasama/edit', [
            'unit' => Unit::all(),
            'prodi' => prodi::all(),
            'perjanjian' => pks::all(),
            'kriteria_mitra' => kriteria_mitra::all(),
            'kriteria_kemitraan' => kriteria_kemitraan::all(),
            'data' => Kerjasama::findOrFail($id),
            'jenisKerjasama' => Jenis_kerjasama::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kerjasama  $kerjasama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kerjasama $kerjasama)
    {
        $validator = Validator::make($request->all(), [
                'id' => 'required',
                'mitra' => 'required',
                'kerjasama' => 'required',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
                'nomor' => 'nullable',
                'kegiatan' => 'nullable',
                'sifat' => 'required',
                'jenis_kerjasama_id' => 'required',
                'kriteria_mitra_id' => 'required',
                'kriteria_kemitraan_id' => 'required',
                'perjanjian' => 'required',
                'jurusan' => 'required',
                'pic_pnj' => 'required',
                'alamat_perusahaan' => 'required',
                'pic_industri' => 'required',
                'jabatan_pic_industri' => 'required',
                // 'telp_industri' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                // 'email' => 'required|email',
                'file' => 'file|mimes:pdf,doc,docx|max:10240',
            ],
            ['telp_industri.regex' => 'Format nomer telpon tidak valid',
            'email.email' => 'Format email tidak valid',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX',
            'tanggal_mulai.after' => 'Tanggal mulai harus lebih awal dibandingkan tanggal selesai',
            'tanggal_selesai.after' => 'Tanggal selesai harus lebih awal dibandingkan tanggal mulai',
            'telp_industri.regex' => 'Format nomer telpon harus angka dan spasi, plus, minus, titik, atau koma',
            'file.max' => 'File maksimal 10MB',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }



        if ($request->telp_industri) {
            $request->validate([
                'telp_industri' => 'regex:/^([0-9\s\-\+\(\)]*)$/',
            ]);
        }

        $file = $request->file('file');
        //buat jadi repo
        $kerjasama = Kerjasama::findOrFail($request->id);
        $repo = Repository::create([
            'mitra' => $kerjasama->mitra,
            'kerjasama' => $kerjasama->kerjasama,
            'kerjasama_id' => $kerjasama->id,
            'user_id' => Auth::user()->id,
            'tanggal_mulai' => $kerjasama->tanggal_mulai,
            'tanggal_selesai' => $kerjasama->tanggal_selesai,
            'nomor' => $kerjasama->nomor,
            'kegiatan' => $kerjasama->kegiatan,
            'sifat' => $kerjasama->sifat,
            'jenis_kerjasama_id' => $kerjasama->jenis_kerjasama_id,
            'kriteria_mitra_id' => $kerjasama->kriteria_mitra_id,
            'kriteria_kemitraan_id' => $kerjasama->kriteria_kemitraan_id,
            'pks' => $kerjasama->pks,
            'jurusan' => $kerjasama->jurusan,
            'prodi' => $kerjasama->prodi,
            'pic_pnj' => $kerjasama->pic_pnj,
            'alamat_perusahaan' => $kerjasama->alamat_perusahaan,
            'pic_industri' => $kerjasama->pic_industri,
            'jabatan_pic_industri' => $kerjasama->jabatan_pic_industri,
            'telp_industri' => $kerjasama->telp_industri,
            'email' => $kerjasama->email,
            'file' => $kerjasama->file,
        ]);

        if ($repo) {
            if ($file) {
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $move = Storage::disk('surat_kerjasama')->put($nama_file, file_get_contents($file));
                if ($move) {
                    $update = Kerjasama::findOrFail($request->id)->update([
                        'mitra' => $request->mitra,
                        'kerjasama' => $request->kerjasama,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_selesai' => $request->tanggal_selesai,
                        'nomor' => $request->nomor,
                        'kegiatan' => $request->kegiatan,
                        'sifat' => $request->sifat,
                        'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                        'kriteria_mitra_id' => $request->kriteria_mitra_id,
                        'kriteria_kemitraan_id' => $request->kriteria_kemitraan_id,
                        'pks' => implode(',', $request->perjanjian),
                        'jurusan' => implode(',', $request->jurusan),
                        'prodi' => implode(',', $request->prodi),
                        'pic_pnj' => $request->pic_pnj,
                        'alamat_perusahaan' => $request->alamat_perusahaan,
                        'pic_industri' => $request->pic_industri,
                        'jabatan_pic_industri' => $request->jabatan_pic_industri,
                        'telp_industri' => $request->telp_industri,
                        'email' => $request->email,
                        'file' => $nama_file,
                        'step' => $kerjasama->step,
                    ]);
                    if ($update) {
                        return redirect('/admin/kerjasama')->with('success', 'Berhasil mengupdate');
                    } else {
                        return redirect('/admin/kerjasama')->with('error', 'Gagal mengupdate data');
                    }
                } else {
                    return redirect('/admin/kerjasama')->with('error', 'Gagal mengupload file');
                }
            } else {
                $update = Kerjasama::findOrFail($request->id)->update([
                    'mitra' => $request->mitra,
                    'kerjasama' => $request->kerjasama,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'nomor' => $request->nomor,
                    'kegiatan' => $request->kegiatan,
                    'sifat' => $request->sifat,
                    'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                    'kriteria_mitra_id' => $request->kriteria_mitra_id,
                    'kriteria_kemitraan_id' => $request->kriteria_kemitraan_id,
                    'pks' => implode(',', $request->perjanjian),
                    'jurusan' => implode(',', $request->jurusan),
                    'prodi' => implode(',', $request->prodi),
                    'pic_pnj' => $request->pic_pnj,
                    'alamat_perusahaan' => $request->alamat_perusahaan,
                    'pic_industri' => $request->pic_industri,
                    'jabatan_pic_industri' => $request->jabatan_pic_industri,
                    'telp_industri' => $request->telp_industri,
                    'email' => $request->email,
                    'step' => $kerjasama->step,
                ]);
                if ($update) {
                    return redirect('/admin/kerjasama')->with('success', 'Berhasil mengupdate');
                } else {
                    return redirect('/admin/kerjasama')->with('error', 'Gagal mengupdate data');
                }
            }
        } else {
            echo "gagal membuat repository";
        }
    }

    public function delete($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);

        // Menghapus file jika ada
        if ($kerjasama->file) {
            $filePath = $kerjasama->file;
            if (Storage::disk('surat_kerjasama')->exists($filePath)) {
                Storage::disk('surat_kerjasama')->delete($filePath);
            }
        }

        // Menghapus data kerjasama dari database
        $delete = $kerjasama->delete();

        if ($delete) {
            return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data dan file berhasil dihapus');
        } else {
            return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal dihapus');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kerjasama  $kerjasama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kerjasama $kerjasama, $id)
    {
        dd($id);
    }
    public function export(Request $request)
    {
        try {
            $filename = 'Data-Kerjasama-' . Carbon::now()->format('Y-m-d_H-i-s.v') . '.xlsx';
            return Excel::download(new KerjasamaExport($request->all()), $filename);

        } catch (\Exception $e) {
            \Log::error('Export failed: ' . $e->getMessage());
            return back()->with('error', 'Export failed. Please try again.: '.$e->getMessage());
        }

    }
}
