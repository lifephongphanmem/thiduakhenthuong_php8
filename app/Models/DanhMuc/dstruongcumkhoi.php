<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dstruongcumkhoi extends Model
{
    protected $table = 'dstruongcumkhoi';
    protected $fillable = [
        'id',
        'madanhsach',
        'ngaytu',
        'ngayden',
        'mota',
        'ghichu',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
    ];
}
