<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log_persetujuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kerjasama_id',
        'user_id', // masukin user yang review
        'role_id', // role id dari user yang review
        'step', // capture  step yang di review
    ];
    public function kerjasama(){
        $this->belongsTo(kerjasama::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function getStep(){
        switch ($this->step) {
            case 1:
                return 'Menunggu';
            case 2:
                return 'Ditolak';
            case 3:
                return 'Disetujui';
            case 4:
                return 'Ditolak';
            case 5:
                return 'Disetujui';
            case 6:
                return 'Ditolak';
            case 7:
                return 'Disetujui';
            default:
                return 'Tidak Diketahui';
        }
    }


}
