<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class implementationAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mitra',
        'dokumen_agreement'

    ];
}
