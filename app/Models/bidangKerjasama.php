<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bidangKerjasama extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bidang'
    ];

    public function kerjasama(){
        return $this->belongsTo('App\Models\kerjasama');
    }


}
