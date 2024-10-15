<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;
    protected $fillable = [
        'kerjasama',
        'kerjasama_id',
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'nomor',
        'kegiatan',
        'sifat',
        'jenis_kerjasama_id',
        'pks',
        'jurusan',
        'pic_pnj',
        'alamat_perusahaan',
        'pic_industri',
        'jabatan_pic_industri',
        'telp_industri',
        'email',
        'file',
    ];

    public function kerjasama()
    {
        return $this->belongsTo('App\Models\User', 'kerjasama_id');
    }
    public function jenis_kerjasama()
    {
        return $this->belongsTo('App\Models\Jenis_kerjasama', 'jenis_kerjasama_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
