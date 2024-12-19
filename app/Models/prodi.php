<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class prodi extends Model
{
    use HasFactory;
    protected $table = 'prodis';
    protected $fillable = [
        'name',
        'unit_id'
    ];
    public function unit(){
        return $this->belongsTo(Unit::class);
    }

}
