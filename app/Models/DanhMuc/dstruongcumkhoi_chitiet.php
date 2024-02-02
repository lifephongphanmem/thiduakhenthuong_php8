<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dstruongcumkhoi_chitiet extends Model
{
    protected $table = 'dstruongcumkhoi_chitiet';
    protected $fillable = [
        'id',
        'madanhsach',
        'macumkhoi',
        'madonvi',
        'ghichu',
    ];
}
