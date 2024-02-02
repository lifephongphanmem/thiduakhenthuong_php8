<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dsnhomtaikhoan extends Model
{
    protected $table = 'dsnhomtaikhoan';
    protected $fillable = [
        'id',
        'stt',
        'manhomchucnang',
        'tennhomchucnang',
        'ghichu',
    ];
}
