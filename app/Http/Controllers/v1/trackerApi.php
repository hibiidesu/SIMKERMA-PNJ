<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Kerjasama;
use App\Models\kriteria_kemitraan;
use App\Models\kriteria_mitra;
use App\Models\prodi;
use App\Models\Unit;
use Illuminate\Http\Request;

class trackerApi extends Controller
{
    public function getKerjasama($id)
    {
        $data = Kerjasama::with([
            'log_persetujuan',
        ])
            ->where('id', $id)
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'error'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $data->map(function ($kerjasama) {
                $kriteriaMitraIds = explode(',', $kerjasama->kriteria_mitra_id);
                $kriteriaKemitraanIds = explode(',', $kerjasama->kriteria_kemitraan_id);
                $kriteriaMitra = kriteria_mitra::whereIn('id', $kriteriaMitraIds)->get();
                $kriteriaKemitraan = kriteria_kemitraan::whereIn('id', $kriteriaKemitraanIds)->get();
                $jurusanID = explode(',', $kerjasama->jurusan);
                $jurusan = Unit::whereIn('id',$jurusanID)->get();
                $prodiID = explode(',', $kerjasama->prodi);
                $prodi = prodi::whereIn('id',$prodiID)->get();
                return [
                    'id' => $kerjasama->id,
                    'kerjasama' => $kerjasama->kerjasama,
                    'mitra' => $kerjasama->mitra,
                    'tanggal_mulai' => $kerjasama->tanggal_mulai,
                    'tanggal_selesai' => $kerjasama->tanggal_selesai,
                    'nomor' => $kerjasama->nomor,
                    'kegiatan' => $kerjasama->kegiatan,
                    'jenis_kerjasama' => $kerjasama->jenis_kerjasama->jenis_kerjasama,
                    'kriteria_mitra' => $kriteriaMitra->pluck('kriteria_mitra'),
                    'kriteria_kemitraan' => $kriteriaKemitraan->pluck('kriteria_kemitraan'),
                    'sifat' => $kerjasama->sifat,
                    'pks' => $kerjasama->pks,
                    'jurusan' => $jurusan->pluck('name'),
                    'prodi' => $prodi->pluck('name'),
                    'pic_pnj' => $kerjasama->pic_pnj,
                    'alamat_perusahaan' => $kerjasama->alamat_perusahaan,
                    'pic_industri' => $kerjasama->pic_industri,
                    'jabatan_pic_industri' => $kerjasama->jabatan_pic_industri,
                    'telp_industri' => $kerjasama->telp_industri,
                    'catatan' => $kerjasama->catatan,
                    'email' => $kerjasama->email,
                    'file' => asset('surat_kerjasama/' . $kerjasama->file),
                    'step' => $kerjasama->log_persetujuan->map(function ($log) {
                        return [
                            'role' => $log->role->role_name,
                            'user_name' => $log->user->name,
                            'step' => $log->getStep(),
                        ];
                    }),
                ];
            })
        ]);
    }
}
