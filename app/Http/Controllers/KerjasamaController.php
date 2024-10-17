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
        $perjanjian = [];
        foreach (Unit::all() as $item) {
            $unit[$item->id] = $item->name;
        }
        foreach (pks::all() as $item) {
            $perjanjian[$item->id] = $item->pks;
        }

        $data = Kerjasama::orderBy('id', 'desc')->where('step', 3);
        if ($request->has('type') && $request->type != 'all') {
            $data = $data->where('jenis_kerjasama_id', ($request->type - 1));
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

        return view('kerjasama/index', [
            'unit' => $unit,
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
        if ($data->jurusan != '') {
            $unit = Unit::whereIn('id', explode(',', $data->jurusan))->get();
        }
        return view('kerjasama/detail', [
            'unit' => $unit,
            'perjanjian' => $perjanjian,
            'data' => $data,
        ]);
    }
    public function showRepo(Kerjasama $kerjasama, $id)
    {
        $data = Repository::findOrFail($id);
        $perjanjian = pks::whereIn('id', explode(',', $data->pks))->get();
        $unit = "";
        if ($data->jurusan != '') {
            $unit = Unit::whereIn('id', explode(',', $data->jurusan))->get();
        }

        return view('kerjasama/repo', [
            'unit' => $unit,
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
            'perjanjian' => pks::all(),
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
        $request->validate(
            [
                'id' => 'required',
                'kerjasama' => 'required',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
                'nomor' => 'required',
                'kegiatan' => 'nullable',
                'sifat' => 'required',
                'jenis_kerjasama_id' => 'required',
                'perjanjian' => 'required',
                'jurusan' => 'required',
                'pic_pnj' => 'required',
                'alamat_perusahaan' => 'required',
                'pic_industri' => 'required',
                'jabatan_pic_industri' => 'required',
                // 'telp_industri' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                // 'email' => 'required|email',
                'file' => 'file|mimes:pdf,doc,docx',
            ],
            ['telp_industri.regex' => 'format nomer telpon tidak valid']
        );

        if ($request->telp_industri) {
            $request->validate([
                'telp_industri' => 'regex:/^([0-9\s\-\+\(\)]*)$/',
            ]);
        }

        $file = $request->file('file');
        //buat jadi repo
        $kerjasama = Kerjasama::findOrFail($request->id);
        $repo = Repository::create([
            'kerjasama' => $kerjasama->kerjasama,
            'kerjasama_id' => $kerjasama->id,
            'user_id' => Auth::user()->id,
            'tanggal_mulai' => $kerjasama->tanggal_mulai,
            'tanggal_selesai' => $kerjasama->tanggal_selesai,
            'nomor' => $kerjasama->nomor,
            'kegiatan' => $kerjasama->kegiatan,
            'sifat' => $kerjasama->sifat,
            'jenis_kerjasama_id' => $kerjasama->jenis_kerjasama_id,
            'pks' => $kerjasama->pks,
            'jurusan' => $kerjasama->jurusan,
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
                        'kerjasama' => $request->kerjasama,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_selesai' => $request->tanggal_selesai,
                        'nomor' => $request->nomor,
                        'kegiatan' => $request->kegiatan,
                        'sifat' => $request->sifat,
                        'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                        'pks' => implode(',', $request->perjanjian),
                        'jurusan' => implode(',', $request->jurusan),
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
                    'kerjasama' => $request->kerjasama,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'nomor' => $request->nomor,
                    'kegiatan' => $request->kegiatan,
                    'sifat' => $request->sifat,
                    'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                    'pks' => implode(',', $request->perjanjian),
                    'jurusan' => implode(',', $request->jurusan),
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
        $delete = Kerjasama::findOrFail($id)->delete();
        if ($delete) {
            return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data berhasil dihapus');  
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
        return Excel::download(new KerjasamaExport($request->all()), 'kerjasama.xlsx');
    }

    
}
