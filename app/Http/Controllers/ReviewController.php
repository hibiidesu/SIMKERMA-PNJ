<?php

namespace App\Http\Controllers;

use App\Mail\pengajuanBaru;
use Illuminate\Support\Facades\Auth;
use App\Models\Jenis_kerjasama;
use App\Models\Kerjasama;
use App\Models\kriteria_kemitraan;
use App\Models\kriteria_mitra;
use App\Models\log_persetujuan;
use App\Models\pks;
use App\Models\Unit;
use App\Models\User;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Persetujuan;
use App\Models\prodi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



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
        if (Auth::user()->role_id == 3) { // legal
            return view('review/index', [
                'perjanjian' => $perjanjian,
                'data' => Kerjasama::where('step', '=', '1')
                    ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                    ->orWhereNull('target_reviewer_id')
                    ->where('step', '=', '1')
                    ->orderBy('created_at', 'desc')
                    ->get(),
            ]);
        } else if (Auth::user()->role_id == 2) { // wadir 4
            return view('review/index', [
                'perjanjian' => $perjanjian,
                'data' => Kerjasama::where('step', '=', '3')
                    ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                    ->orWhereNull('target_reviewer_id')
                    ->where('step', '=', '3')
                    ->orderBy('created_at', 'desc')
                    ->get(),
            ]);
        } else if (Auth::user()->role_id == 5) { // Direktur
            return view('review/index', [
                'perjanjian' => $perjanjian,
                'data' => Kerjasama::where('step', '=', '5')
                    ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                    ->orWhereNull('target_reviewer_id')
                    ->where('step', '=', '5')
                    ->orderBy('created_at', 'desc')
                    ->get(),
            ]);
        } else if(Auth::user()->role_id == 4) { // PIC
            return view('review/index', [
                'perjanjian' => $perjanjian,
                'data' => Kerjasama::where('user_id', '=', Auth::user()->id)->orderBy('step', 'asc')->get(),
            ]);
        } else if (Auth::user()->role_id == 1) { // Admin
            return view('review/index', [
                'perjanjian' => $perjanjian,
                'data' => Kerjasama::where('step', '=', '5')
                    ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                    ->orWhereNull('target_reviewer_id')
                    ->where('step', '=', '5')
                    ->orderBy('created_at', 'desc')
                    ->get(),
            ]);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function create()
    {
        if(Auth::user()->role_id == 2){

            return view('review/add', [
                'users' => User::where('role_id', '=', '2')->get(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'perjanjian' => pks::all(),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        } else if(Auth::user()->role_id == 3){

            return view('review/add', [
                'users' => User::where('role_id', '=', '3')->get(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'perjanjian' => pks::all(),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        } else if(Auth::user()->role_id == 5){

            return view('review/add', [
                'users' => User::where('role_id', '=', '5')->get(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'perjanjian' => pks::all(),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        } else {
            return view('review/add', [
                'users' => User::where('role_id', '=', '4')->get(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'perjanjian' => pks::all(),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mitra' => 'required',
            'kerjasama' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'sifat' => 'required',
            'kriteria_kemitraan_id' => 'required',
            'kriteria_mitra_id' => 'required',
            'jenis_kerjasama_id' => 'required',
            'perjanjian' => 'required',
            'jurusan' => 'required',
            'pic_pnj' => 'required',
            'alamat_perusahaan' => 'required',
            'pic_industri' => 'required',
            'jabatan_pic_industri' => 'required',
            'telp_industri' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'nullable|email',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'telp_industri.regex' => 'Format nomor telepon tidak valid',
            'file.max' => 'Ukuran file tidak boleh lebih dari 10 MB',
            'file.mimes' => 'Format file yang diperbolehkan hanya PDF, DOC, DOCX',
            'tanggal_mulai.date' => 'Format tanggal mulai harus tanggal',
            'tanggal_selesai.date' => 'Format tanggal selesai harus tanggal',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'email.email' => 'Format email harus valid',
        ]);

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
        $prodi = $request->has('prodi') ? $request->prodi : [];
        $file = $request->file('file');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $move = Storage::disk('surat_kerjasama')->put($nama_file, file_get_contents($file));
        if ($move) {
            $kerjasama = Kerjasama::create([
                'mitra' => $request->mitra,
                'kerjasama' => $request->kerjasama,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'nomor' => $request->nomor,
                'kegiatan' => $request->kegiatan,
                'sifat' => $request->sifat,
                'kriteria_kemitraan_id' => implode(',', $request->kriteria_kemitraan_id),
                'kriteria_mitra_id' => implode(',', $request->kriteria_mitra_id),
                'user_id' => Auth::user()->id,
                'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                'pks' => implode(',', $request->perjanjian),
                'jurusan' => implode(',', $request->jurusan),
                'prodi' => implode(',', $prodi),
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
            $LegalUsers = User::where('role_id', 3)->get();
            foreach ($LegalUsers as $legal) {
                Persetujuan::create([
                    'kerjasama_id' => $kerjasama->id,
                    'user_id' => $legal->id,
                    'status' => 'menunggu',
                ]);

                Mail::to($legal->email)->send(new pengajuanBaru($kerjasama, 'legal'));
            }
            if (Auth::user()->role->role_name == 'pic') {
                return redirect('/pic/pengajuan-kerjasama')->with('success', 'Data berhasil ditambahkan dan menunggu persetujuan legal');
            }  else {
                return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data berhasil ditambahkan dan menunggu persetujuan legal');

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
    }

    public function show($id)
    {
        if (Auth::user()->role_id == 3) {
            $data = Kerjasama::where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                ->where('id', '=', $id)
                ->where('step', '=', '1')
                ->orWhereNull('target_reviewer_id')
                ->where('id', '=', $id)
                ->where('step', '=', '1')
                ->get()
                ->first();
        } else if (Auth::user()->role_id == 2) {
            $data = Kerjasama::where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                ->where('id', '=', $id)
                ->where('step', '=', '3')
                ->orWhereNull('target_reviewer_id')
                ->where('id', '=', $id)
                ->where('step', '=', '3')
                ->get()
                ->first();
        } else if (Auth::user()->role_id == 5 || Auth::user()->role_id == 1) {

            $data = Kerjasama::where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
                ->where('id', '=', $id)
                ->where('step', '=', '5')
                ->orWhereNull('target_reviewer_id')
                ->where('id', '=', $id)
                ->where('step', '=', '5')
                ->get()
                ->first();

        } else {
            $data = Kerjasama::findOrFail($id);
        }
        if ($data) {
            $unit = "";
            $prodi = "";

            if ($data->jurusan != '') {
                $unit = Unit::whereIn('id', explode(',', $data->jurusan))->get();

            }
            if ($data->prodi != '') {
                $prodi = Prodi::whereIn('id', explode(',', $data->prodi))->get();
            }
            $perjanjian = pks::whereIn('id', explode(',', $data->pks))->get();

            return view('review/detail', [
                'prodi' => $prodi,
                'unit' => $unit,
                'prodi' => $prodi,
                'perjanjian' => $perjanjian,
                'data' => $data,
            ]);
        } else {
            if (Auth::user()->role_id == 2) {
                return redirect('/direktur/review')->with('error', 'Akses tidak diizinkan');
            } else if (Auth::user()->role_id == 3) {
                return redirect('/legal/review')->with('error', 'Akses tidak diizinkan');
            } else if (Auth::user()->role_id == 5) {
                return redirect('/direktur/review')->with('error', 'Akses tidak diizinkan');
            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('error', 'Akses tidak diizinkan');
            }
        }
    }

    public function tolakLegal(Request $request)
{
    // dd($request);
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:kerjasamas,id',
        'catatan' => 'required|string',
        'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        'nomor' => 'nullable|string|max:255',
    ], [
        'id.required' => 'ID kerjasama harus diisi.',
        'catatan.required' => 'Catatan harus diisi.',
        'dokumen.mimes' => 'Format file yang diperbolehkan hanya PDF, DOC, atau DOCX.',
        'dokumen.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
        'nomor.max' => 'Nomor tidak boleh lebih dari 255 karakter.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    $kerjasama = Kerjasama::find($request->id);
    if (!$kerjasama) {
        return redirect('/legal/review')->with('error', 'Kerjasama not found.');
    }

    DB::beginTransaction();

    try {
        $updateData = [
            'catatan' => $request->catatan,
            'step' => '2',
            'reviewer_id' => Auth::id(),
        ];


        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $file_name = time() . '.' . $file->getClientOriginalName();

            // Delete the old file if it exists
            if ($kerjasama->file && Storage::disk('surat_kerjasama')->exists($kerjasama->file)) {
                Storage::disk('surat_kerjasama')->delete($kerjasama->file);
            }

            // Store the new file
            Storage::disk('surat_kerjasama')->put($file_name, file_get_contents($file));

            // Update the kerjasama record with the new file name
            $kerjasama->update([
                'file' => $file_name,
            ]);
        }
        if ($request->has('nomor') && !is_null($request->nomor)) {
            $updateData['nomor'] = $request->nomor;
        } else {
            $updateData['nomor'] = $kerjasama->nomor;
        }


        $kerjasama->update($updateData);

        log_persetujuan::create([
            'kerjasama_id' => $kerjasama->id,
            'user_id' => Auth::id(),
            'role_id' => Auth::user()->role_id,
            'step' => 2,
        ]);


        Mail::to($kerjasama->user->email)->send(new \App\Mail\tolakPengajuan($kerjasama, $request->catatan));

        DB::commit();
        return redirect('/legal/review')->with('success', 'Data berhasil ditolak');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect('/legal/review')->with('error', 'An error occurred: ' . $e->getMessage());
    }
}


    public function tolakWadir(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'catatan' => 'required',
        ]);
        $kerjasama = Kerjasama::findOrFail($request->id);
        $update = $kerjasama->update([
            'catatan' => $request->catatan,
            'step' => '4',
            'reviewer_id' => Auth::user()->id,
        ]);
        if ($update) {
            log_persetujuan::create([
                'kerjasama_id' => $kerjasama->id,
                'user_id' => Auth::user()->id,
                'role_id' => Auth::user()->role_id,
                'step' => 4
            ]);
            mail::to($kerjasama->user->email)->send(new \App\Mail\tolakPengajuan($kerjasama,$request->catatan));
            // mail::to($kerjasama->email)->send(new \App\Mail\tolakPengajuanMitra($kerjasama,$request->catatan));
            return redirect('/pemimpin/review')->with('success', 'Data berhasil ditolak');
        } else {
            return redirect('/pemimpin/review')->with('error', 'Data gagal ditolak');
        }
    }

    public function tolakDirektur(Request $request)

    {
        $request->validate([
            'id' => 'required',
            'catatan' => 'required',
        ]);
        $kerjasama = Kerjasama::findOrFail($request->id);
        $update = $kerjasama->update([
            'catatan' => $request->catatan,
            'step' => '6',
            'reviewer_id' => Auth::user()->id,
        ]);
        if ($update) {
            log_persetujuan::create([
                'kerjasama_id' => $kerjasama->id,
                'user_id' => Auth::user()->id,
                'role_id' => Auth::user()->role_id,
                'step' => 6
            ]);
            mail::to($kerjasama->user->email)->send(new \App\Mail\tolakPengajuan($kerjasama,$request->catatan));
            // mail::to($kerjasama->email)->send(new \App\Mail\tolakPengajuanMitra($kerjasama,$request->catatan));
            if(Auth::user()->role_id == 1){
                return redirect('/admin/review')->with('success', 'Data berhasil ditolak');
            }
            return redirect('/direktur/review')->with('success', 'Data berhasil ditolak');
        } else {
            if(Auth::user()->role_id == 1){
                return redirect('/admin/review')->with('error', 'Data gagal ditolak');
            }
            return redirect('/direktur/review')->with('error', 'Data gagal ditolak');
        }
    }

    public function terimaLegal($id)
    {

        $kerjasama = Kerjasama::findOrFail($id);
        $update = $kerjasama->update([
            'step' => '3', // current_step + 2
            'reviewer_id' => Auth::user()->id,
        ]);
        if ($update) {
            log_persetujuan::create([
                'kerjasama_id' => $kerjasama->id,
                'user_id' => Auth::user()->id,
                'role_id' => Auth::user()->role_id,
                'step' => 3
            ]);
            mail::to($kerjasama->user->email)->send(new \App\Mail\terimaPengajuan($kerjasama));
            // mail::to($kerjasama->email)->send(new \App\Mail\terimaPengajuanMitra($kerjasama));
            $PemimpinUsers = User::where('role_id', 2)->get();
            foreach ($PemimpinUsers as $i) {
                Persetujuan::create([
                    'kerjasama_id' => $kerjasama->id,
                    'user_id' => $i->id,
                    'status' => 'menunggu',
                ]);
                Mail::to($i->email)->send(new pengajuanBaru($kerjasama, 'pemimpin'));
            }
            return redirect('/legal/review')->with('success', 'Data berhasil diterima');
        } else {
            return redirect('/legal/review')->with('error', 'Data gagal diterima');
        }
    }

    public function terimaWadir($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);
        $update = $kerjasama->update([
            'step' => '5',
            'reviewer_id' => Auth::user()->id,
        ]);
        if ($update) {
            log_persetujuan::create([
                'kerjasama_id' => $kerjasama->id,
                'user_id' => Auth::user()->id,
                'role_id' => Auth::user()->role_id,
                'step' => 5
            ]);
            mail::to($kerjasama->user->email)->send(new \App\Mail\terimaPengajuan($kerjasama));
            mail::to($kerjasama->email)->send(new \App\Mail\terimaPengajuanMitra($kerjasama));
            $DirekturUsers = User::where('role_id', 5)->get();
            foreach ($DirekturUsers as $i) {
                Persetujuan::create([
                    'kerjasama_id' => $kerjasama->id,
                    'user_id' => $i->id,
                    'status' => 'menunggu',
                ]);
                Mail::to($i->email)->send(new pengajuanBaru($kerjasama, 'direktur'));
            }
            return redirect('/pemimpin/review')->with('success', 'Data berhasil diterima');
        } else {
            return redirect('/pemimpin/review')->with('error', 'Data gagal diterima');
        }
    }

    public function terimaDirektur($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);
        $update = $kerjasama->update([
            'step' => '7', // current_step + 2
            'reviewer_id' => Auth::user()->id,
        ]);
        if ($update) {
            log_persetujuan::create([
                'kerjasama_id' => $kerjasama->id,
                'user_id' => Auth::user()->id,
                'role_id' => Auth::user()->role_id,
                'step' => 7
            ]);
            mail::to($kerjasama->user->email)->send(new \App\Mail\terimaPengajuan($kerjasama));
            mail::to($kerjasama->email)->send(new \App\Mail\terimaPengajuanMitra($kerjasama));
            if(Auth::user()->role_id == 1){
                return redirect('/admin/review')->with('success', 'Data berhasil diterima');
            }

            return redirect('/direktur/review')->with('success', 'Data berhasil diterima');
        } else {
            if (Auth::user()->role_id == 1){
                return redirect('/admin/review')->with('error', 'Data gagal diterima');
            }

            return redirect('/direktur/review')->with('error', 'Data gagal diterima');
        }
    }
    public function dokumenAkhirAdmin(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:kerjasamas,id',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'id.required' => 'ID kerjasama harus diisi.',
            'id.exists' => 'ID kerjasama tidak valid.',
            'dokumen.file' => 'Dokumen harus berupa file.',
            'dokumen.mimes' => 'Format file yang diperbolehkan hanya PDF, DOC, atau DOCX.',
            'dokumen.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
        ]);

        $kerjasama = Kerjasama::find($request->id);
        if (!$kerjasama) {
            return redirect('/admin/pengajuan-kerjasama')->with('error', 'Kerjasama not found.');
        }
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $file_name = time() . '.' . $file->getClientOriginalName();

            if ($kerjasama->file && Storage::disk('surat_kerjasama')->exists($kerjasama->file)) {
                Storage::disk('surat_kerjasama')->delete($kerjasama->file);
            }

            Storage::disk('surat_kerjasama')->put($file_name, file_get_contents($file));

            $kerjasama->update([
                'file' => $file_name,
            ]);
        }
        return redirect('admin/pengajuan-kerjasama')->with('success', 'Dokumen Tanda Tangan Berhasil Di rubah');

    }


    public function edit($id)
    {

        if (Auth::user()->role_id == 2) {
            return view('review/edit', [
                'users' => User::where('role_id', '=', '2')->get(),
                'perjanjian' => pks::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'data' => Kerjasama::findOrFail($id),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        } else if (Auth::user()->role_id == 3) {
            return view('review/edit', [
                'users' => User::where('role_id', '=', '3')->get(),
                'perjanjian' => pks::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'data' => Kerjasama::findOrFail($id),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        } else if (Auth::user()->role_id == 5) {
            return view('review/edit', [
                'users' => User::where('role_id', '=', '5')->get(),
                'perjanjian' => pks::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'data' => Kerjasama::findOrFail($id),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        }
         else if (Auth::user()->role_id == 1) {
            return view('review/edit', [
                'users' => User::where('role_id', '=', '1')->get(),
                'perjanjian' => pks::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'data' => Kerjasama::findOrFail($id),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        }
        else if (Auth::user()->role_id == 4) {
            return view('review/edit', [
                'users' => User::where('role_id', '=', '1')->get(),
                'perjanjian' => pks::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'data' => Kerjasama::findOrFail($id),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);

        }
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
        $prodi = $request->has('prodi') ? $request->prodi : [];
        $file = $request->file('file');
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
                    'user_id' => Auth::user()->id,
                    'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                    'kriteria_mitra_id' => $request->kriteria_mitra_id,
                    'kriteria_kemitraan_id' => $request->kriteria_kemitraan_id,
                    'pks' => implode(',', $request->perjanjian),
                    'jurusan' => implode(',', $request->jurusan),
                    'prodi' => implode(',', $prodi),
                    'target_reviewer_id' => $request->target_reviewer ? implode(',', $request->target_reviewer) : null,
                    'pic_pnj' => $request->pic_pnj,
                    'alamat_perusahaan' => $request->alamat_perusahaan,
                    'pic_industri' => $request->pic_industri,
                    'jabatan_pic_industri' => $request->jabatan_pic_industri,
                    'telp_industri' => $request->telp_industri,
                    'email' => $request->email,
                    'catatan' => null,
                    'file' => $nama_file,
                    'step' => 1,
                ]);
                if ($update) {
                    $redirectRoute = Auth::user()->role_id == 4 ? '/pic/pengajuan-kerjasama' : '/admin/pengajuan-kerjasama';
                    return redirect($redirectRoute)->with('success', 'Data berhasil diubah');
                } else {
                    $redirectRoute = Auth::user()->role_id == 4 ? '/pic/pengajuan-kerjasama' : '/admin/pengajuan-kerjasama';
                    return redirect($redirectRoute)->with('error', 'Data gagal diubah');
                }

            } else {
                return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal dipindahkan');
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
                'kriteria_mitra_id' => is_array($request->kriteria_mitra_id) ? implode(',',$request->kriteria_mitra_id) : $request->kriteria_mitra_id ,
                'kriteria_kemitraan_id' => is_array($request->kriteria_kemitraan_id) ? implode(',',$request->kriteria_kemitraan_id) : $request->kriteria_kemitraan_id ,
                'pks' => is_array($request->perjanjian) ? implode(',', $request->perjanjian) : $request->perjanjian,
                'target_reviewer_id' => $request->target_reviewer ? implode(',', $request->target_reviewer) : null,
                'jurusan' => is_array($request->jurusan) ? implode(',', $request->jurusan) : $request->jurusan,
                'prodi' => is_array($prodi) ? implode(',', $prodi) : $prodi,
                'pic_pnj' => $request->pic_pnj,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'pic_industri' => $request->pic_industri,
                'jabatan_pic_industri' => $request->jabatan_pic_industri,
                'telp_industri' => $request->telp_industri,
                'email' => $request->email,
                'catatan' => null,
                'step' => 1,
            ]);
            if ($update) {
                $redirectRoute = Auth::user()->role_id == 4 ? '/pic/pengajuan-kerjasama' : '/admin/pengajuan-kerjasama';
                return redirect($redirectRoute)->with('success', 'Data berhasil diubah');
            } else {
                $redirectRoute = Auth::user()->role_id == 4 ? '/pic/pengajuan-kerjasama' : '/admin/pengajuan-kerjasama';
                return redirect($redirectRoute)->with('error', 'Data gagal diubah');
            }
        }

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

    public function  record(){
        if(Auth::user()->role_id == 1){
            return view('review/record', [
                'users' => User::where('role_id', '=', '1')->get(),
                'kriteria_mitra' => kriteria_mitra::all(),
                'kriteria_kemitraan' => kriteria_kemitraan::all(),
                'unit' => Unit::all(),
                'prodi' => Prodi::all(),
                'perjanjian' => pks::all(),
                'jenisKerjasama' => Jenis_kerjasama::all(),
            ]);
        } else {
            return error('Anda Tidak Memiliki Hak Akses');
        }
    }

    public function store_record(Request $request){
        $validator = Validator::make($request->all(), [
            'mitra' => 'required',
            'kerjasama' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'nomor' => 'required',
            'sifat' => 'required',
            'kriteria_kemitraan_id' => 'required',
            'kriteria_mitra_id' => 'required',
            'jenis_kerjasama_id' => 'required',
            'perjanjian' => 'required',
            'jurusan' => 'required',
            'pic_pnj' => 'required',
            'alamat_perusahaan' => 'required',
            'pic_industri' => 'required',
            'jabatan_pic_industri' => 'required',
            'telp_industri' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'nullable|email',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'telp_industri.regex' => 'Format nomor telepon tidak valid',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX',
            'email.email' => 'Format email tidak valid',
            'tanggal_mulai.date' => 'Format tanggal mulai harus dalam format tanggal',
            'tanggal_selesai.date' => 'Format tanggal selesai harus dalam format tanggal',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
        ]);

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
        $prodi = $request->has('prodi') ? $request->prodi : [];
        $file = $request->file('file');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $move = Storage::disk('surat_kerjasama')->put($nama_file, file_get_contents($file));
        if ($move) {
            $kerjasama = Kerjasama::create([
                'mitra' => $request->mitra,
                'kerjasama' => $request->kerjasama,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'nomor' => $request->nomor,
                'kegiatan' => $request->kegiatan,
                'sifat' => $request->sifat,
                'kriteria_kemitraan_id' => implode(',', $request->kriteria_kemitraan_id),
                'kriteria_mitra_id' => implode(',', $request->kriteria_mitra_id),
                'user_id' => Auth::user()->id,
                'jenis_kerjasama_id' => $request->jenis_kerjasama_id,
                'pks' => implode(',', $request->perjanjian),
                'jurusan' => implode(',', $request->jurusan),
                'prodi' => implode(',', $prodi),
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

            $update = $kerjasama->update([
                'step' => '3',
                'reviewer_id' => Auth::user()->id,
            ]);
            if ($update) {
                log_persetujuan::create([
                    'kerjasama_id' => $kerjasama->id,
                    'user_id' => Auth::user()->id,
                    'role_id' => 3,
                    'step' => 3
            ]);}

            $update = $kerjasama->update([
                'step' => '5',
                'reviewer_id' => Auth::user()->id,
            ]);
            if ($update) {
                log_persetujuan::create([
                    'kerjasama_id' => $kerjasama->id,
                    'user_id' => Auth::user()->id,
                    'role_id' => 2,
                    'step' => 5
            ]);}
            $update = $kerjasama->update([
                'step' => '7',
                'reviewer_id' => Auth::user()->id,
            ]);
            if ($update) {
                log_persetujuan::create([
                    'kerjasama_id' => $kerjasama->id,
                    'user_id' => Auth::user()->id,
                    'role_id' => 5,
                    'step' => 7
            ]);}

            if (Auth::user()->role->role_name == 'admin') {
                return redirect('/admin/pengajuan-kerjasama')->with('success', 'Data berhasil direkam');
            }  else {
                return redirect('/login')->with('error', 'Anda tidak memiliki hak akses');
            }

        } else {
            return redirect('/admin/pengajuan-kerjasama')->with('error', 'Data gagal ditambahkan');
        }
    }
}
