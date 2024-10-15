<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;

    protected $table = 'persetujuans';

    protected $fillable = [
        'kerjasama_id',
        'user_id',
        'status',
        'catatan',
    ];
    public function kerjasama()
    {
        return $this->belongsTo(Kerjasama::class, 'kerjasama_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'menunggu':
                return 'Menunggu';
            case 'disetujui':
                return 'Disetujui';
            case 'ditolak':
                return 'Ditolak';
            default:
                return 'Tidak Diketahui';
        }
    }
}