<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dsvanbancumkhoi extends Model
{
    protected $table = 'dsvanbancumkhoi';
    protected $fillable = [
        'id',
        'mavanban',
        'kyhieuvb',
        'dvbanhanh',
        'loaivb',
        'trangthai',
        'ngayqd',
        'ngayapdung',
        'tieude',
        'ghichu',
        'phanloai',
        'madonvi',
        'tinhtrang',
        'ngaytinhtrang',
        'vanbanbosung',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
    ];
}
