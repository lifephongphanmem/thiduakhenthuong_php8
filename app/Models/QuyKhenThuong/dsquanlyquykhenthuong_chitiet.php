<?php

namespace App\Models\QuyKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dsquanlyquykhenthuong_chitiet extends Model
{
    protected $table = 'dsquanlyquykhenthuong_chitiet';
    protected $fillable = [
        'id',
        'maso',
        'phanloai', //THU;CHI
        'phannhom',
        'tentieuchi',
        'sotien',
        'stt',
    ];
}
