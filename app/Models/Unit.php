<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'unit';
    protected $fillable = [
        'name',
    ];
    public function kerjasama()
    {
        return $this->hasMany('App\Models\Kerjasama');
    }
    public function repository()
    {
        return $this->hasMany('App\Models\Repository');
    }
}
