<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kerjasama extends Model
{
    use HasFactory;
    protected $fillable = [
        'mitra',
        'kerjasama',
        'tanggal_mulai',
        'tanggal_selesai',
        'nomor',
        'kegiatan',
        'sifat',
        'kriteria_kemitraan_id',
        'kriteria_mitra_id',
        'jenis_kerjasama_id',
        'kriteria_mitra_id',
        'kriteria_kemitraan_id',
        'pks',
        'jurusan',
        'prodi',
        'pic_pnj',
        'alamat_perusahaan',
        'pic_industri',
        'jabatan_pic_industri',
        'telp_industri',
        'email',
        'file',
        'step',
        'catatan',
        'reviewer_id',
        'target_reviewer_id',
        'user_id',
    ];

    public function repository()
    {
        return $this->hasMany('App\Models\Repository')->orderBy('created_at', 'desc');
    }
    public function log_persetujuan()
    {
        return $this->hasMany('App\Models\log_persetujuan')->orderBy('created_at', 'desc');
    }
    public function jenis_kerjasama()
    {
        return $this->belongsTo('App\Models\Jenis_kerjasama', 'jenis_kerjasama_id');
    }
    public function pks()
    {
        return $this->belongsTo('App\Models\pks', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function reviewer()
    {
        return $this->belongsTo('App\Models\User', 'reviewer_id');
    }
    public function kriteriaKemitraan()
    {
        return $this->belongsTo('App\Models\kriteria_kemitraan');
    }
    public function kriteriaMitra()
    {
        return $this->belongsTo('App\Models\kriteria_mitra');
    }
}
