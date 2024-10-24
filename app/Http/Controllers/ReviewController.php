<?php

namespace App\Http\Controllers;

use App\Mail\pengajuanBaru;
use Illuminate\Support\Facades\Auth;
use App\Models\Jenis_kerjasama;
use App\Models\Kerjasama;
use App\Models\pks;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Persetujuan;
use Illuminate\Support\Facades\Mail;



class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $perjanjian = [];
        foreach (pks::all() as $item) {
            $perjanjian[$item->id] = $item->pks;
        }
        if (Auth::user()->role_id == 2) {
            return view('review/index', [
                'perjanjian' => $perjanjian,
                'data' => Kerjasama::where('step', '=', '1')
                    ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                    ->orWhereNull('target_reviewer_id')
                    ->where('step', '=', '1')
                    ->orderBy('created_at', 'desc')
                    ->get(),
            ]);
        } else {
            return view('review/index', [
                'perjanjian' => $perjanjian,
                'data' => Kerjasama::where('user_id', '=', Auth::user()->id)->orderBy('step', 'asc')->get(),
            ]);
        }
    }

    public function create()
    {
        return view('review/add', [
            'users' => User::where('role_id', '=', '2')->get(),
            'unit' => Unit::all(),
            'perjanjian' => pks::all(),
            'jenisKerjasama' => Jenis_kerjasama::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'kerjasama' => 'required',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
                'nomor' => 'required',
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
                'file' => 'required|file|mimes:pdf,doc,docx',
            ],
            ['telp_industri.regex' => 'format nomor telpon tidak valid']
        );

        if ($request->telp_industri) {
            $request->validate([
                'telp_industri' => 'regex:/^([0-9\s\-\+\(\)]*)$/',
            ]);
        }
        $file = $request->file('file');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $move = Storage::disk('surat_kerjasama')->put($nama_file, file_get_contents($file));
        if ($move) {
            $kerjasama = Kerjasama::create([
                'kerjasama' => $request->kerjasama,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'nomor' => $request->nomor,
                'kegiatan' => $request->kegiatan,
                'sifat' => $request->sifat,
                'user_id' => Auth::user()->id,
                'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                'pks' => implode(',', $request->perjanjian),
                'jurusan' => implode(',', $request->jurusan),
                'target_reviewer_id' => $request->target_reviewer ? implode(',', $request->target_reviewer) : null,
                'pic_pnj' => $request->pic_pnj,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'pic_industri' => $request->pic_industri,
                'jabatan_pic_industri' => $request->jabatan_pic_industri,
                'telp_industri' => $request->telp_industri,
                'email' => $request->email,
                'file' => $nama_file,
                'step' => 1,
            ]);

            // Buat persetujuan untuk setiap pemimpin
            $pemimpinUsers = User::where('role_id', 2)->get();
            foreach ($pemimpinUsers as $pemimpin) {
                Persetujuan::create([
                    'kerjasama_id' => $kerjasama->id,
                    'user_id' => $pemimpin->id,
                    'status' => 'menunggu',
                ]);
                Mail::to($pemimpin->email)->send(new pengajuanBaru(
                    $request->kerjasama, 
                    $request->tanggal_mulai, 
                    $request->tanggal_selesai, 
                    $request->kegiatan,
                    $request->sifat,
                    $request->pic_pnj,
                ));
            }
            if (Auth::user()->role->role_name == 'pic') {
                return redirect('/pic/pengajuan-kerjasama')->with('success', 'Data berhasil ditambahkan dan menunggu persetujuan pemimpin');
            }  else { 
                return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data berhasil ditambahkan dan menunggu persetujuan pemimpin');
            }
            
        } else {
            if (Auth::user()->role->role_name == 'pic') {
                return redirect('/pic/pengajuan-kerjasama')->with('error', 'Data gagal ditambahkan');
            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal ditambahkan');
            }
            
        }
        dd($request->input());
    }

    public function show($id)
    {
        if (Auth::user()->role_id == 2) {
            $data = Kerjasama::where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                ->where('id', '=', $id)
                ->where('step', '=', '1')
                ->orWhereNull('target_reviewer_id')
                ->where('id', '=', $id)
                ->where('step', '=', '1')
                ->get()
                ->first();
        } else {
            $data = Kerjasama::findOrFail($id);
        }
        if ($data) {
            $unit = "";
            if ($data->jurusan != '') {
                $unit = Unit::whereIn('id', explode(',', $data->jurusan))->get();
            }
            $perjanjian = pks::whereIn('id', explode(',', $data->pks))->get();

            return view('review/detail', [
                'unit' => $unit,
                'perjanjian' => $perjanjian,
                'data' => $data,
            ]);
        } else {
            if (Auth::user()->role_id == 2) {
                return redirect('/pemimpin/review')->with('error', 'Akses tidak diizinkan');
            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('error', 'Akses tidak diizinkan');
            }
        }
    }

    public function tolak(Request $request)
    {   
        $request->validate([
            'id' => 'required',
            'catatan' => 'required',
        ]);
        $kerjasama = Kerjasama::findOrFail($request->id);
        $update = $kerjasama->update([
            'catatan' => $request->catatan,
            'step' => '2',
            'reviewer_id' => Auth::user()->id,
        ]);
        if ($update) {
            mail::to($kerjasama->user->email)->send(new \App\Mail\tolakPengajuan($kerjasama,$request->catatan));
            return redirect('/pemimpin/review')->with('success', 'Data berhasil ditolak');
        } else {
            return redirect('/pemimpin/review')->with('error', 'Data gagal ditolak');
        }
        dd($request->input());
    }

    public function terima($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);
        $update = $kerjasama->update([
            'step' => '3',
            'reviewer_id' => Auth::user()->id,
        ]);
        if ($update) {
            // get user from kerjasama then send the email 
            mail::to($kerjasama->user->email)->send(new \App\Mail\terimaPengajuan($kerjasama));
            return redirect('/pemimpin/review')->with('success', 'Data berhasil diterima');
        } else {
            return redirect('/pemimpin/review')->with('error', 'Data gagal diterima');
        }
    }

    public function edit($id)
    {
        return view('review/edit', [
            'users' => User::where('role_id', '=', '2')->get(),
            'perjanjian' => pks::all(),
            'unit' => Unit::all(),
            'data' => Kerjasama::findOrFail($id),
            'jenisKerjasama' => Jenis_kerjasama::all(),
        ]);
    }

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
                    'target_reviewer_id' => $request->target_reviewer ? implode(',', $request->target_reviewer) : null,
                    'jurusan' => implode(',', $request->jurusan),
                    'pic_pnj' => $request->pic_pnj,
                    'alamat_perusahaan' => $request->alamat_perusahaan,
                    'pic_industri' => $request->pic_industri,
                    'jabatan_pic_industri' => $request->jabatan_pic_industri,
                    'telp_industri' => $request->telp_industri,
                    'email' => $request->email,
                    'file' => $nama_file,
                    'step' => 1,
                ]);
                if ($update) {
                    return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data berhasil diubah');
                } else {
                    return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal diubah');
                }
            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal dipindahkan');
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
                'target_reviewer_id' => $request->target_reviewer ? implode(',', $request->target_reviewer) : null,
                'jurusan' => implode(',', $request->jurusan),
                'pic_pnj' => $request->pic_pnj,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'pic_industri' => $request->pic_industri,
                'jabatan_pic_industri' => $request->jabatan_pic_industri,
                'telp_industri' => $request->telp_industri,
                'email' => $request->email,
                'step' => 1,
            ]);
            if ($update) {
                return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data berhasil diubah');
            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal diubah');
            }
        }

        dd($request->input());
    }

    public function delete($id)
    {
        $delete = Kerjasama::findOrFail($id)->delete();
        if ($delete) {
            if (Auth::user()->role->role_name == 'pic') {
                return redirect('/pic/pengajuan-kerjasama')->with('success', 'Data berhasil dihapus');
            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data berhasil dihapus');
            }
            
        } else {
            if (Auth::user()->role->role_name == 'pic') {
                return redirect('/pic/pengajuan-kerjasama')->with('error', 'Data gagal dihapus');
            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal dihapus');
            }
            
        }
    }
}